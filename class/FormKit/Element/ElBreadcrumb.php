<?php

namespace FormKit\Element;

use FormKit\ComponentNode;
use Symfony\Contracts\Translation\TranslatorInterface;

class ElBreadcrumb extends ComponentNode
{

    function separator(string $value)
    {
        $this->setAttribute('separator', $value);
        return $this;
    }

    function separatorIcon(string $value)
    {
        $this->setAttribute('separator-icon', $value);
        return $this;
    }

    function addBreadcrumbItem()
    {
        return $this->appendHTML('<el-breadcrumb-item></el-breadcrumb-item>')[0];
    }
}
