<?php

namespace VX;

use Exception;
use Symfony\Component\Yaml\Yaml;

class Module
{
    public $name;
    public $class;
    public $icon = "far fa-circle";
    public $group;
    public $sequence = PHP_INT_MAX;
    public $hide = false;

    public $menu = [];

    public function __construct(string $name, array $config = [])
    {
        $this->name = $name;
        $this->class = $name;

        foreach ($config as $k => $v) {
            $this->$k = $v;
        }
    }

    public function loadConfigFile(string $filename)
    {
        if (file_exists($filename)) {
            $yaml = new Yaml;
            $config = $yaml->parseFile($filename);
            foreach ($config as $k => $v) {
                $this->$k = $v;
            }
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


        $submenu = $this->getMenuLink();
        if (count($submenu) == 1) {

            $data["link"] = $submenu[0]["link"];
        } else {
            $data["link"] = "#";
            $data["submenu"] = $submenu;
        }


        return $data;
    }

    public function getMenuLink(): array
    {

        $links = [];

        $link = [];
        $link["label"] = "List";
        $link["icon"] = "fa fa-list";
        $link["link"] = "/" . $this->name;
        $links[] = $link;


        if ($this->show_create) {
            $link = [];
            $link["label"] = "Add";
            $link["icon"] = "fa fa-plus";
            $link["link"] = "/" . $this->name . "/ae";
            $links[] = $link;
        }



        foreach ($this->menu as $name => $m) {
            $link = $m;

            $links[] = $link;
        }


        return $links;
    }
}
