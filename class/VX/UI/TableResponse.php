<?php

namespace VX\UI;

use Closure;
use JsonSerializable;
use VX;

class TableResponse implements JsonSerializable
{
    /**
     * @var \R\ORM\Query $source
     */
    public $source;
    public $per_page;
    public $offset;
    public $sort;
    public $search;

    public function __construct(VX $vx, $query)
    {
        $this->vx = $vx;
        $this->page = intval($vx->_get["page"]);
        $this->per_page = intval($vx->_get["per_page"]);
        $this->offset = intval(($this->page - 1) * $this->per_page);

        $this->sort = $vx->_get["sort"];
        $this->search = json_decode($vx->_get["search"], true);
    }

    public function filteredSource()
    {
        $source = clone $this->source;

        if ($this->search) {
            foreach ($this->search as $name => $value) {
                $col = $this->getColumn($name);

                if (!$col) continue;

                if ($value === null  || $value === "") continue;



                if (is_array($value)) { //between
                    $source->filter([
                        $name => [
                            "between" => $value
                        ]
                    ]);
                } else {


                    $b_name = ":" . $name;
                    $source->where("`$name`" . " like $b_name", [$name => "%$value%"]);
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
            $source->orderBy($sort);
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
    }

    public function data()
    {
        $data = [];
        $source = $this->orderedSource();


        if ($this->page) {
            $source->limit($this->per_page);
            $source->offset($this->offset);
        }


        foreach ($source as $obj) {

            $d = [];
            foreach ($this->columns as $column) {

                $prop = $column["prop"];
                $getter = $column["getter"];
                if ($getter instanceof Closure) {
                    //$d[$prop] = call_user_func($getter, [$obj]);
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
