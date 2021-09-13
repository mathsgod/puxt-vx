<?php

namespace VX\UI;


use P\HTMLElement;
use PHP\Util\QueryInterface;
use Traversable;
use VX\IModel;
use VX\TranslatorAwareInterface;
use VX\TranslatorAwareTrait;
use VX\UI\EL\TableColumn;
use VX\User;

class T extends HTMLElement implements TranslatorAwareInterface
{
    use TranslatorAwareTrait;

    protected $user;

    public function __construct()
    {
        parent::__construct("el-table");
    }

    public function setUser(User $user)
    {
        $this->user = $user;
    }

    public function setData(iterable $data)
    {
        $this->data = $data;
        if ($this->data instanceof Traversable) {
            $this->data = iterator_to_array($this->data);
        }
    }


    public function addActionColumn()
    {
        $data = $this->getAttribute(":data");
        $data = json_decode($data, true) ?? [];

        if ($this->user) {
            foreach ($this->data as $i => $d) {
                $data[$i] = $data[$i] ?? [];
                if ($d instanceof IModel) {
                    if ($d->canReadBy($this->user)) {
                        $data[$i]["__view__"] = $d->uri("view");
                    }
                    if ($d->canUpdateBy($this->user)) {
                        $data[$i]["__update__"] = $d->uri("ae");
                    }
                }
            }
        }

        $this->setAttribute(":data", json_encode($data, JSON_UNESCAPED_UNICODE));

        $this->append($column = new TableActionColumn);

        $column->setAttribute("v-slot:default", "props");
        $column->setTranslator($this->translator);

        $column->setAttribute("width", "115");
        $column->setAttribute("min-width", "115");

        return $column;
    }


    public function add(string $label, string $prop)
    {
        $col = new TableColumn;
        $col->setLabel($label);
        $col->setProp($prop);
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
