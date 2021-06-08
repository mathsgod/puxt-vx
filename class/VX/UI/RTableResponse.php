<?php

namespace VX\UI;

use \Box\Spout\Writer\WriterFactory;
use \Box\Spout\Common\Type;

use JsonSerializable;
use Exception;
use Psr\Http\Message\RequestInterface;
use VX;
use VX\IModel;

class Row
{
    public $style = null;
    public $class = null;

    public function style($callback)
    {
        $this->style = $callback;
        return $this;
    }

    public function addClass($callback)
    {
        $this->class = $callback;
        return $this;
    }

    public function getData($obj)
    {
        $r = [];
        if ($this->style) {
            $r["style"] = call_user_func($this->style, $obj);
        }
        if ($this->class) {
            $r["class"] = call_user_func($this->class, $obj);
        }
        return $r;
    }
}

/**
 * @property \VX $context
 */
class RTableResponse implements JsonSerializable
{
    public $fields = [];
    public $source = null;

    public $_columns = [];
    public $page = 1;
    public $length;
    public $key;
    public $row;

    public $columns = [];
    public $context;
    public $order = [];

    public function __construct(VX $context, $query)
    {
        $this->context = $context;
        $this->draw = intval($query["draw"]);
        $this->request["columns"] = $query["columns"];

        if ($query["order"]) {
            foreach ($query["order"] as $order) {
                $this->order[] = json_decode($order, true);
            }
        }

        $this->page = intval($query["page"]);
        $this->length = intval($query["length"]);
        $this->row = new Row();
        $this->search = [];
        if ($query["search"]) {
            foreach ($query["search"] as $s) {
                $this->search[] = json_decode($s, true);
            }
        }

        foreach ($this->request["columns"] as $column) {
            if ($column == "__view__") {
                $this->addView();
            }

            if ($column == "__edit__") {
                $this->addEdit();
            }

            if ($column == "__del__") {
                $this->addDel();
            }
        }
    }

    public function setKey(string $key)
    {
        $this->key = $key;
        return $this;
    }

    public function where()
    {
        $where = [];
        return $where;
    }

    public function addEdit()
    {
        $that = $this;
        $c = new Column();
        $c->title = "";
        $c->type = "html";
        $c->data = "__edit__";
        $c->name = "__edit__";
        $c->className[] = "text-center";
        $c->width = "1px";
        $c->descriptor[] = function (IModel $obj) use ($that) {
            if (is_array($obj)) {
                if ($obj["canUpdate"]) {
                    $uri = $that->model . "/" . $obj[$that->key] . "/ae";
                    $a = html("router-link")->class("btn btn-sm btn-warning text-white")->href($uri);
                    $a->i->class("fa fa-pencil-alt fa-fw");
                    return $a;
                }
                return;
            }

            if (!$obj->canUpdateBy($this->context->user)) {
                return;
            }
            $a = html("router-link")->class("btn btn-sm btn-warning text-white")->to($obj->uri("ae"));
            $a->i->class("fa fa-pencil-alt fa-fw");
            return "<vue>$a</vue>";
        };
        $this->_columns["__edit__"] = $c;
        return $c;
    }

    public function addView()
    {
        $that = $this;
        $c = new Column();
        $c->title = "";
        $c->type = "html";
        $c->data = "__view__";
        $c->name = "__view__";
        $c->className[] = "text-center";
        $c->width = "1px";
        $c->descriptor[] = function ($obj) use ($that) {

            if (is_array($obj)) {
                if ($obj["canView"]) {
                    $uri = $that->model . "/" . $obj[$that->key] . "/view";
                    $a = html("router-link")->class("btn btn-sm btn-info")->to($uri);
                    $a->i->class("fa fa-search fa-fw");
                    return $a;
                }
                return;
            }

            if (!$obj->canReadBy($this->context->user)) {
                return;
            }
            $a = html("router-link")->class("btn btn-sm btn-info")->to($obj->uri("view"));
            $a->i->class("fa fa-search fa-fw");

            return "<vue>$a</vue>";
        };
        $this->_columns["__view__"] = $c;
        return $c;
    }


    public function addDel()
    {

        $c = new Column();
        $c->title = "";
        $c->type = "delete";
        $c->data = "__del__";
        $c->name = "__del__";
        $c->width = "1px";
        $c->className[] = "text-center";
        $that = $this;
        $c->descriptor[] = function ($obj) use ($that) {
            if (is_array($obj)) {
                if ($obj["canDelete"]) {
                    return $that->model . "/" . $obj[$that->key];
                }
                return;
            }

            if (!$obj->canDeleteBy($this->context->user)) {
                return;
            }
            return $obj->uri();
        };
        $this->_columns["__del__"] = $c;
        return $c;
    }

    public function addSubRow($name, $func, $key)
    {
        $path = $func[0]->path();

        $url = $path . "/$func[1]";
        $c = new Column();
        $c->title = "";
        $c->type = "sub-row";
        $c->name = $name;
        $c->url = $url;
        $c->key = $key;
        $this->_columns[$name] = $c;
        return $c;
    }

    public function add($name, $getter)
    {
        $c = new Column();
        $c->name = $name;
        $c->descriptor[] = $getter;

        $this->_columns[$name] = $c;

        return $c;
    }

    public function data()
    {
        foreach ($this->fields as $c) {
            $this->add($c, $c);
        }

        $source = $this->filteredSource();


        if ($this->page) {
            $source->limit($this->length);
            $source->offset($this->length * ($this->page - 1));
        }


        $data = [];
        foreach ($source as $obj) {
            $d = [];

            $d["__row__"] = $this->row->getData($obj);

            if (is_array($obj)) {
                $object_vars = $obj;
            } else {
                $object_vars = get_object_vars($obj);
            }


            foreach ($this->request["columns"] as $k => $c) {
                try {
                    if (array_key_exists($c, $this->_columns)) {
                        $col = $this->_columns[$c];

                        if ($col->type == "sub-row") {
                            $d[$c] = ["type" => "subrow", "url" => $col->url, "params" => [$col->key =>  $object_vars[$col->key]]];
                        } elseif ($col->type == "delete") {
                            if ($content = (string) $col->getData($obj, $c)) {
                                $d[$c] = ["type" => $col->type, "content" => (string) $content];
                            } else {
                                $d[$c] = null;
                            }
                        } elseif ($col->type == "text") {
                            $d[$c] = (string) $col->getData($obj, $k);
                        } elseif ($col->type == "html") {

                            $content = $col->getData($obj, $c);
                            $d[$c] = ["type" => "html", "content" => (string) $content];
                        } elseif ($col->type == "vue") {
                            $content = $col->getData($obj, $c);
                            $d[$c] = ["type" => "vue", "content" => (string) $content];
                        } else {
                            $v = $col->getData($obj, $c);

                            if (is_array($v)) {
                                $d[$c] = $v;
                            } else {
                                $d[$c] = (string) $v;
                            }
                        }
                    } elseif (array_key_exists($c, $object_vars)) {
                        $d[$c] = $object_vars[$c];
                    } else {
                        $d[$c] = null;
                    }
                } catch (Exception $e) {
                    $d[$c] = $e->getMessage();
                }
            }

            if ($this->key) {
                $key = $this->key;
                $d[$key] = $obj->$key;
            }

            $data[] = $d;
        }


        return $data;
    }

    public function recordsTotal()
    {
        return $this->source->count();
    }

    public function search()
    {
        $search = [];
        foreach ($this->request["search"] as  $c) {
            $search[$c["name"]] = $c["value"];
        }
        return $search;
    }

    public function filteredSource()
    {
        $source = clone $this->source;

        if (is_array($this->order)) {
            foreach ($this->order as $o) {
                $column = $this->_columns[$o["name"]];
                if ($column->order) {
                    $source->orderBy($column->order . " " . $o["dir"]);
                } elseif ($column->sortCallback) {
                    $source->orderBy(call_user_func($column->sortCallback) . " " . $o["dir"]);
                } else {
                    $source->orderBy([$o["name"] => $o["dir"]]);
                }
            }
        }




        foreach ($this->search as $k => $c) {
            $column = $this->_columns[$c["name"]];
            $value = $c["value"];

            if ($value !== null && $value !== "") {

                if ($column->searchCallback) {
                    $c = call_user_func($column->searchCallback, $value);

                    $source->where($c[0], $c[1]);
                    continue;
                }

                if ($c["method"] == "in") {
                    $field = $c["name"];
                    $s = [];
                    $p = [];
                    foreach ($value as $k) {
                        $s[] = "?{$field}_{$k}";
                        $p["{$field}_{$k}"] = $k;
                    }

                    $source->where("$field in (" . implode(",", $s) . ")", $p);
                    continue;
                } elseif ($c["method"] == "like") {
                    $name = ":" . $c["name"];
                    $source->where($c["name"] . " like $name", [$name => "%$value%"]);
                } elseif ($c["method"] == "eq") {
                    $source->filter([$c["name"] => $value]);
                } elseif ($c["method"] == "between") {

                    $from = $value[0];
                    $to = $value[1];
                    if ($from == $to) {
                        $field = $c["name"];
                        $name = ":" . $field;
                        $source->where("date(`$field`) = $name", [$name => $from]);
                    } else {
                        $field = $c["name"];
                        $field_from = ":" . $field . "_from";
                        $field_to = ":" . $field . "_to";
                        $source->where("date(`$field`) between $field_from and $field_to", [
                            $field_from => $from,
                            $field_to => $to
                        ]);
                    }
                }
            }
        }


        return $source;
    }

    public function recordsFiltered()
    {
        $source = $this->filteredSource();
        return $source->count();
    }

    public function jsonSerialize()
    {
        //parse columns
        foreach ($this->columns as $name => $c) {
            if (is_string($c)) {
                $this->add($name, $c);
            } elseif (is_array($c)) {

                $col = $this->add($name, $c["content"]);
                if ($c["format"]) {
                    $col->format($c["format"]);
                }
                if ($c["alink"]) {
                    $col->alink($c["alink"]);
                }
            }
        }


        if ($_GET["type"]) {
            $this->exportFile($_GET["type"]);
            exit();
            return null;
        }

        $ret = [
            "draw" => $this->draw,
            "data" => $this->data(),
            "total" => $this->recordsFiltered()
        ];

        if ($this->key) {
            $ret["key"] = $this->key;
        }

        return $ret;
    }

    public function exportFile($type)
    {

        switch ($type) {
            case "xlsx":
                $t = Type::XLSX;
                break;
            case "csv":
                $t = Type::CSV;
                break;
        }
        $writer = WriterFactory::create($t);
        $writer->openToFile("php://output");

        $data = $this->data();

        foreach ($this->request["columns"] as $k => $c) {

            $col = $this->_columns[$c["data"]];

            if ($col->type != "text") continue;

            $row[] = $c["data"];
            $cols[] = $c["data"];
        }


        $writer->addRow($row);


        foreach ($data as $d) {
            $ds = [];
            foreach ($cols as $c) {
                if (is_array($d[$c])) {
                    $ds[$c] = $d[$c]["content"];
                } else {
                    $ds[$c] = $d[$c];
                }
            }
            $writer->addRow($ds);
        }

        $writer->close();
    }
}
