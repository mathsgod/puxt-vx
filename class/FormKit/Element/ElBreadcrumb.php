<?php

namespace FormKit\Element;

use FormKit\ComponentNode;
use Symfony\Contracts\Translation\TranslatorInterface;

class ElBreadcrumb extends ComponentNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct('ElBreadcrumb', $property, $translator);
    }

    function separator(string $value)
    {
        $this->props['separator'] = $value;
        return $this;
    }

    function separatorIcon(string $value)
    {
        $this->props['separator-icon'] = $value;
        return $this;
    }

    function addBreadcrumbItem()
    {
        $component = new ElBreadcrumbItem([], $this->translator);
        $this->children[] = $component;
        return $component;
    }
}
