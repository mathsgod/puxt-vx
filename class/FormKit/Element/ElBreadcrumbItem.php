<?php

namespace FormKit\Element;

use FormKit\ComponentNode;
use Symfony\Contracts\Translation\TranslatorInterface;

class ElBreadcrumbItem extends ComponentNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct('ElBreadcrumbItem', $property, $translator);
    }

    /**
     * target route of the link, same as to of vue-router
     */
    function to(string $value)
    {
        $this->props['to'] = $value;
        return $this;
    }

    /**
     * 	if true, the navigation will not leave a history record
     */
    function replace(bool $value = true)
    {
        $this->props['replace'] = $value;
        return $this;
    }
}
