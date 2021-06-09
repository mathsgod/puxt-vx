<?php

namespace VX\UI;


use P\HTMLElement;
use PHP\Util\QueryInterface;

class T extends HTMLElement
{
    public function __construct()
    {
        parent::__construct("el-table");
    }

    public function setData($data)
    {
        $this->data = $data;
        if ($this->data instanceof QueryInterface) {
            $this->data = iterator_to_array($this->data);
        }
    }

    public function add(string $label, string $prop)
    {
        $col = new TColumn();
        $col->setAttribute("label", $label);
        $col->setAttribute("prop", $prop);
        $this->append($col);

        $data = $this->getAttribute(":data");
        $data = json_decode($data, true) ?? [];


        $dd = [];
        foreach ($this->data as $d) {
            $dd[] = var_get($d, $prop);
        }

        foreach ($dd as $i => $d) {
            $data[$i][$prop] = $dd[$i];
        }

        $this->setAttribute(":data", json_encode($data, JSON_UNESCAPED_UNICODE));

        return $col;
    }

    private static $I = 0;
    public function addHTML(string $label, callable $call)
    {
        $prop = "_col_html_" . self::$I;
        self::$I++;

        $col = new TColumn();
        $col->setAttribute("label", $label);
        $this->append($col);

        $template = new HTMLElement("template");
        $template->setAttribute("slot-scope", "scope");
        $p = new HTMLElement("p");
        $p->setAttribute("v-html", "scope.row.$prop");
        $template->append($p);

        $col->append($template);

        //
        $data = $this->getAttribute(":data");
        $data = json_decode($data, true) ?? [];

        $dd = [];
        foreach ($this->data as $d) {
            $dd[] = $call($d);
        }

        foreach ($dd as $i => $d) {
            $data[$i][$prop] = (string) $dd[$i];
        }

        $this->setAttribute(":data", json_encode($data, JSON_UNESCAPED_UNICODE));



        return $col;
    }
}
