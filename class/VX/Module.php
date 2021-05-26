<?php

namespace VX;

use Exception;

class Module
{
    public $name;
    public $class;
    public $icon;
    public $group;
    public $sequence = PHP_INT_MAX;
    public $hide = false;

    public function __construct(string $name, array $config = [])
    {
        $this->name = $name;
        $this->class = $name;

        foreach ($config as $k => $v) {
            $this->$k = $v;
        }
    }

    public function getObject(int $id): IModel
    {
        $class = $this->class;
        try {
            $obj = new $class($id);
            return $obj;
        } catch (Exception $e) {
        }
    }

    public function getMenuItem(): array
    {
        $data = [];
        $data["label"] = $this->name;
        $data["icon"] = $this->icon;


        if ($sub = $this->getMenuLink()) {
            $data["link"] = $this->name;
            $data["submenu"] = $sub;
        } else {
            $data["link"] = "#";
        }


        return $data;
    }

    public function getMenuLink(): array
    {

        $links = [];

        $link = [];
        $link["label"] = "List";
        $link["icon"] = "fa fa-list";
        $link["link"] = $this->name;
        $links[] = $link;


        if ($this->show_create) {
            $link = [];
            $link["label"] = "Add";
            $link["icon"] = "fa fa-plus";
            $link["link"] = $this->name . "/ae";
            $links[] = $link;
        }





        return $links;
    }
}
