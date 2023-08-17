<?php

namespace FormKit\Element;

use FormKit\ComponentNode;
use Symfony\Contracts\Translation\TranslatorInterface;

class ElBreadcrumbItem extends ComponentNode
{

    /**
     * target route of the link, same as to of vue-router
     */
    function to(string $value)
    {
        $this->setAttribute('to', $value);
        return $this;
    }

    /**
     * 	if true, the navigation will not leave a history record
     */
    function replace(bool $value = true)
    {
        $this->setAttribute('replace', $value);
        return $this;
    }
}
