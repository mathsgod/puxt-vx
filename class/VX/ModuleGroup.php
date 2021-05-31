<?php

namespace VX;

class ModuleGroup
{
    public $name;
    public $child = [];

    public function __construct(string $name)
    {
        $this->name = $name;
    }


    public function add(Module $module)
    {
        $this->child[] = $module;
    }

    public function getMenuItem()
    {
        $data = [];

        $data["label"] = $this->name;
        $data["icon"] = "far fa-circle";

        $data["link"] = "#";

        $submenu = [];
        foreach ($this->child as $child) {
            $submenu[] = $child->getMenuItem();
        }
        $data["submenu"] = $submenu;

        return $data;
    }
}
