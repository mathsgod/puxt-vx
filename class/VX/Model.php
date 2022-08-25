<?php

namespace VX;

use Laminas\Permissions\Acl\Resource\ResourceInterface;
use R\DB\Model as DBModel;
use ReflectionClass;
use ReflectionObject;
use TheCodingMachine\GraphQLite\Annotations\Field;

class Model extends DBModel implements ResourceInterface, IModel
{

    public static function FromGlobal(): static
    {
        $vx = self::$_vx;
        return $vx->object();
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

    public function getResourceId()
    {
        $r = new ReflectionClass(static::class);
        return $r->getShortName();
    }

    public function canDeleteBy(User $user): bool
    {
        return self::$_vx->getAcl()->isAllowed($user, $this, "delete");
    }

    public function canReadBy(User $user): bool
    {
        return self::$_vx->getAcl()->isAllowed($user, $this, "read");
    }

    public function canUpdateBy(User $user): bool
    {
        return self::$_vx->getAcl()->isAllowed($user, $this, "update");
    }

    public function canCreateBy(User $user): bool
    {
        return self::$_vx->getAcl()->isAllowed($user, $this, "create");
    }

    public function createdBy(): ?User
    {
        if ($this->created_by) {
            return User::Get($this->created_by);
        }
        return null;
    }

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


    public function bind($rs)
    {
        if (is_object($rs)) {
            $rs = get_object_vars($rs);
        }

        // B1 Super Admin Account Takeover
        //remove primary key
        $key = self::_key();
        if (isset($rs[$key])) {
            unset($rs[$key]);
        }

        return parent::bind($rs);
    }


    public function toArray(?array $fields = null): array
    {
        $key = self::_key();
        $data = [];
        $data[$key] = $this->$key;
        foreach ($this->__fields() as $field) {

            if ($fields && !in_array($field, $fields)) {
                continue;
            }

            $data[$field] = $this->$field;
        }

        if (in_array("createdBy", $fields)) {
            $user = $this->createdBy();
            if ($user) {
                $data["createdBy"] = [
                    "user_id" => $user->user_id,
                    "name" => $user->getName(),
                ];
            }
        }


        $relection_object = new ReflectionObject($this);

        foreach ($relection_object->getMethods() as $method) {
            foreach ($method->getAttributes() as $attribute) {
                if ($attribute->getName() == Field::class) {

                    if (in_array($method->getName(), $fields)) {
                        $data[$method->getName()] = $this->{$method->getName()}();
                    }
                }
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


        if (in_array("__canRead", $fields)) {
            $data["__canRead"] = $this->canReadBy(self::$_vx->user);
        }

        if (in_array("__canUpdate", $fields)) {
            $data["__canUpdate"] = $this->canUpdateBy(self::$_vx->user);
        }

        if (in_array("__canDelete", $fields)) {
            $data["__canDelete"] = $this->canDeleteBy(self::$_vx->user);
        }



        return $data;
    }
}
