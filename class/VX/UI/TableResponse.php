<?php

namespace VX\UI;

use Closure;
use JsonSerializable;
use Laminas\Db\Sql\Where;
use Laminas\Hydrator\ObjectPropertyHydrator;
use VX;
use VX\IModel;

class TableResponse implements JsonSerializable
{
    /**
     * @var \R\DB\Query $source
     */
    public $source;
    public $per_page;
    public $offset;
    public $sort;
    public $search;
    public $filter;
    public $search_callback = [];
    public $sort_callback = [];
    public $data_map;

    public function __construct(VX $vx, $query)
    {
        $this->vx = $vx;
        $this->page = intval($vx->_get["page"]);

        $this->per_page = intval($vx->_get["per_page"]);
        $this->offset = intval(($this->page - 1) * $this->per_page);

        $this->sort = $vx->_get["sort"];
        $this->search = json_decode($vx->_get["search"], true);
        $this->filter = json_decode($vx->_get["filter"], true);


        $this->metadata = $vx->jwtDecode($vx->_get["metadata"])["data"];


        //base on the columns of metadata
        foreach ($this->metadata["columns"] as $column) {
            $this->add($column["prop"]);
        }

        $columns = $this->metadata["columns"];
        $props = array_column($columns, "prop");


        if (in_array("__view__", $props)) {
            $this->add("__view__", function ($obj) use ($vx) {
                if ($obj instanceof IModel) {
                    if ($obj->canReadBy($vx->user)) {
                        return $obj->uri("view");
                    }
                }
                return false;
            });
        }

        if (in_array("__update__", $props)) {
            $this->add("__update__", function ($obj) use ($vx) {
                if ($obj instanceof IModel) {
                    if ($obj->canUpdateBy($vx->user)) {
                        return $obj->uri("ae");
                    }
                }
                return false;
            });
        }

        if (in_array("__delete__", $props)) {
            $this->add("__delete__", function ($obj) use ($vx) {
                if ($obj instanceof IModel) {
                    if ($obj->canDeleteBy($vx->user)) {
                        return $obj->uri();
                    }
                }
                return false;
            });
        }

        $this->setDataMap(fn ($o) => $o);
    }

    function setData(\R\DB\Query $source)
    {
        $this->source = $source;
    }

    /**
     * @deprecated use setData
     */
    function setSource(\R\DB\Query $source)
    {
        $this->source = $source;
    }

    public function addSortCallback(string $prop, callable $callback)
    {
        $this->sort_callback[$prop] = $callback;
    }

    public function addSearchCallback(string $prop, callable $callback)
    {
        $this->search_callback[$prop] = $callback;
    }

    public function filteredSource()
    {
        $source = clone $this->source;

        if ($this->filter) {
            $source->where($this->filter);
        }


        if ($this->search) {
            foreach ($this->search as $name => $value) {
                $col = $this->getColumn($name);


                if (!$col) continue;

                if ($value === null  || $value === "") continue;


                if ($this->search_callback[$name]) {
                    $this->search_callback[$name]($source->where, $value);
                    continue;
                }


                if (is_array($value)) { //between
                    $source->where(function (Where $where) use ($name, $value) {
                        $where->between($name, $value[0], $value[1]);
                    });
                } else {

                    $source->where(function (Where $where) use ($name, $value) {
                        $where->like($name, "%$value%");
                    });
                }
            }
        }
        return $source;
    }

    private function getColumn(string $prop)
    {
        foreach ($this->columns as $col) {
            if ($col["prop"] == $prop) {
                return $col;
            }
        }
        return null;
    }

    public function orderedSource()
    {
        $source = clone $this->filteredSource();
        if ($this->sort) {
            $ss = explode("|", $this->sort, 2);
            $sort = [];
            $sort[$ss[0]] = ($ss[1] == "descending") ? "desc" : "asc";

            if ($callback = $this->sort_callback[$ss[0]]) {
                $callback($source, $sort[$ss[0]]);
                return $source;
            }

            $source->order($sort);
        }
        return $source;
    }

    public function add(string $prop, mixed $getter = null)
    {
        $c = [];
        $c["prop"] = $prop;
        if (is_null($getter)) {
            $c["getter"] = $prop;
        } else {
            $c["getter"] = $getter;
        }

        $this->columns[] = $c;
        return $c;
    }

    public function setDataMap(callable $map)
    {
        $this->data_map = $map;
    }

    public function data()
    {
        $data = [];
        $source = $this->orderedSource();


        if ($this->page && $this->per_page) {
            $source->limit($this->per_page);
            $source->offset($this->offset);
        }

        if ($this->data_map instanceof Closure) {
            foreach ($source as $obj) {
                foreach ($this->columns as $column) {

                    $prop = $column["prop"];
                    $getter = $column["getter"];
                    if ($getter instanceof Closure) {
                        $d[$prop] = call_user_func($getter, $obj);
                    } else {
                        $d[$prop] = var_get($obj, $getter);
                    }
                }

                $dmap = $this->data_map->__invoke($obj);
                if (is_object($dmap)) {
                    $hydrator = new ObjectPropertyHydrator();
                    $dmap = $hydrator->extract($dmap);
                }
                foreach ($dmap as $k => $v) {
                    $d[$k] = $v;
                }

                $data[] = $d;
            }
            return $data;
        }

        foreach ($source as $obj) {

            $d = [];
            foreach ($this->columns as $column) {

                $prop = $column["prop"];
                $getter = $column["getter"];
                if ($getter instanceof Closure) {
                    $d[$prop] = call_user_func($getter, $obj);
                } else {
                    $d[$prop] = var_get($obj, $getter);
                }
            }

            $data[] = $d;
        }
        return $data;
    }

    public function jsonSerialize()
    {
        return [
            "page" => $this->page,
            "total" => $this->total(),
            "data" => $this->data()
        ];
    }

    public function total()
    {
        return $this->filteredSource()->count();
    }
}
