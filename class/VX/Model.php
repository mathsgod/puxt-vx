<?php

namespace VX;

use R\DB\Model as DBModel;
use R\DB\Query;
use ReflectionClass;
use ReflectionObject;
use TheCodingMachine\GraphQLite\Annotations\Field;
use VX\Security\AssertionInterface;
use VX\Security\Security;
use VX\Security\UserInterface;

class Model extends DBModel implements ModelInterface, AssertionInterface
{
    function assert(Security $security, UserInterface $user, string $permission): bool
    {
        if ($user->is("Administrators")) return true;
        //get name
        $name = (new ReflectionObject($this))->getShortName();
        return $security->isGranted($user, $name . "." . $permission);
    }

    public static function Sort(Query $q, string $sort, string $order)
    {
    }

    public static function Filter(Query $q, string $filter, string $operator, $value)
    {
    }

    public static function QueryData(array $query, UserInterface $user, Security $security)
    {
        $fields = array_column(self::__attributes(), "Field");

        $meta = [];
        $meta["primaryKey"] = static::_key();

        /** @var \R\DB\Query */
        $q = static::Query();

        if ($filters = $query["filters"]) {

            foreach ($filters as $field => $filter) {

                foreach ($filter as $operator => $value) {

                    if (in_array($field, $fields)) {
                        if ($operator == '$eq') {
                            $q->where->equalTo($field, $value);
                        }

                        if ($operator == '$contains') {
                            $q->where->like($field, "%$value%");
                        }

                        if ($operator == '$in') {
                            $q->where->in($field, $value);
                        }

                        if ($operator == '$between') {
                            $q->where->between($field, $value[0], $value[1]);
                        }

                        if ($operator == '$gt') {
                            $q->where->greaterThan($field, $value);
                        }

                        if ($operator == '$gte') {
                            $q->where->greaterThanOrEqualTo($field, $value);
                        }

                        if ($operator == '$lt') {
                            $q->where->lessThan($field, $value);
                        }

                        if ($operator == '$lte') {
                            $q->where->lessThanOrEqualTo($field, $value);
                        }

                        if ($operator == '$ne') {
                            $q->where->notEqualTo($field, $value);
                        }
                    } else {
                        //custom filter
                        static::Filter($q, $field, $operator, $value);
                    }
                }
            }
        }

        $meta["total"] = $q->count();

        if ($sort = $query["sort"]) {
            $order = [];
            foreach ($sort as $s) {
                $ss = explode(":", $s);

                if (in_array($ss[0], $fields)) {
                    $order[$ss[0]] = $ss[1];
                } else {
                    //call user defined sort
                    static::Sort($q, $ss[0], $ss[1]);
                }
            }
            $q->order($order);
        }

        if ($pagination = $query["pagination"]) {
            $paginator = $q->getPaginator();
            $paginator->setCurrentPageNumber($pagination["page"]);
            $paginator->setItemCountPerPage($pagination["pageSize"]);

            $q = $paginator;

            $meta["pagination"] = [
                "page" => $paginator->getCurrentPageNumber(),
                "pageSize" => $paginator->getItemCountPerPage(),
                "total" => $paginator->getTotalItemCount()
            ];
        }

        $data = [];
        foreach ($q as $o) {
            if ($o instanceof Model) {


                if ($security->isGranted($user, "list", $o)) {
                    $obj = $o->toArray($query["fields"] ?? []);

                    if ($populate = $query["populate"]) {
                        foreach ($populate as $target_module => $p) {

                            $module = self::$_vx->getModule($target_module);
                            $target_class = $module->class;
                            $target_key = $target_class::_key();
                            $p["filters"] = $p["filters"] ?? [];

                            $d = [];
                            if (in_array($target_key, $o->__fields())) { // many to one
                                $p["filters"][$target_key]['$eq'] = $o->$target_key;
                                $d = $module->class::QueryData($p, $user, $security);
                                $d["data"] = $d["data"][0];

                                $obj[$target_module] = $d["data"];
                            } else { //one to many
                                $p["filters"][$meta["primaryKey"]]['$eq'] = $o->{$meta["primaryKey"]};
                                $d = $module->class::QueryData($p, $user, $security);
                                $obj[$target_module] = $d["data"];
                            }
                        }
                    }

                    $data[] = $obj;
                }
            }
        }

        return  [
            "data" => $data,
            "meta" => $meta
        ];
    }

    public static function FromGlobal(): static
    {
        $vx = self::$_vx;
        if ($vx->module) {
            return $vx->module->getObject($vx->object_id);
        }
    }

    static $_db;
    public static function __db()
    {
        return self::$_db;
    }

    /**
     * @var \VX $_vx
     */
    public static $_vx;


    public function _id()
    {
        $key = static::_key();
        return $this->$key;
    }


    #[Field]
    public function createdBy(): ?User
    {
        if ($this->created_by) {
            return User::Get($this->created_by);
        }
        return null;
    }

    #[Field]
    public function updatedBy(): ?User
    {
        if ($this->updated_by) {
            return User::Get($this->updated_by);
        }
        return null;
    }

    public function uri(?string $name = null): string
    {
        $reflect = new ReflectionClass($this);
        $uri = $reflect->getShortName();

        $key = $key = self::_key();
        if ($this->$key) {
            $uri .= "/" . $this->$key;
        }
        if (isset($name)) {
            $uri .= "/" . $name;
        }

        return "/" . $uri;
    }

    public function __call($function, $args)
    {
        $class = get_class($this);

        //check const
        $c = new \ReflectionClass($class);
        if ($const = $c->getConstants()) {

            $decamlize = function ($string) {
                return strtolower(preg_replace(['/([a-z\d])([A-Z])/', '/([^_])([A-Z][a-z])/'], '$1_$2', $string));
            };
            $field = $decamlize($function);

            if (array_key_exists(strtoupper($field), $const)) {
                return $const[strtoupper($field)][$this->$field];
            }

            if (array_key_exists($function, $const)) {
                return $const[$function][$this->$field];
            }
        }
        return parent::__call($function, $args);
    }

    public function toArray(?array $fields = []): array
    {
        $key = self::_key();
        $data = [];
        $data[$key] = $this->$key;
        $ro = new ReflectionObject($this);

        //field include dot
        foreach ($fields as $field) {
            if (is_array($field)) continue;

            if (in_array($field, $this->__fields())) {
                $data[$field] = $this->$field;
            } elseif (strpos($field, ".") !== false) {
                $f = explode(".", $field, 2);
                if (!$ro->hasMethod($f[0])) continue;

                $method = $ro->getMethod($f[0]);
                if (!$method->getAttributes(Field::class)) continue;
                $obj = $this->{$method->getName()}();

                if ($obj && $obj instanceof Model) {
                    $data[$f[0]] = $obj->toArray([$f[1]]);
                }
            } else {

                if (!$ro->hasMethod($field)) continue;
                $method = $ro->getMethod($field);
                if (!$method->getAttributes(Field::class)) continue;
                $data[$field] = $this->{$method->getName()}();
            }
        }


        if (in_array("__createdBy", $fields)) {
            $user = $this->createdBy();
            if ($user) {
                $data["__createdBy"] = $user->getName();
            } else {
                $data["__createdBy"] = null;
            }
        }


        $secruity = self::$_vx->getSecurity();
        if (in_array("__canRead", $fields)) {
            $data["__canRead"] = $secruity->isGranted(self::$_vx->user, "read", $this);
        }

        if (in_array("__canUpdate", $fields)) {
            $data["__canUpdate"] = $secruity->isGranted(self::$_vx->user, "update", $this);
        }

        if (in_array("__canDelete", $fields)) {
            $data["__canDelete"] =  $secruity->isGranted(self::$_vx->user, "delete", $this);
        }

        return $data;
    }
}
