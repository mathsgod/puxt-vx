<?php

namespace VX;

use Laminas\Permissions\Acl\Resource\ResourceInterface;

class ModuleFile implements ResourceInterface
{
    public $module;
    public string $path;
    public string $name;

    public function __construct(Module $module, $path)
    {
        $this->module = $module;

        $this->path = $path;

        $this->name = pathinfo($path, PATHINFO_FILENAME);
    }

    public function getResourceId()
    {
        return $this->module->getResourceId() . "/" . $this->name;
    }
}
