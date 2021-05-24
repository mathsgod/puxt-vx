<?php

namespace VX;

class ModuleGroup
{

    public static $All = [];
    public static function CreateOrLoad(string $name): self
    {
        if (!self::$All[$name]) {
            self::$All[$name] = new self($name);
        }

        return self::$All[$name];
    }

    public $child = [];
    public function add(Module $module)
    {
        $this->child[] = $module;
    }
}
