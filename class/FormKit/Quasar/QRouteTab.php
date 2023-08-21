<?php

namespace FormKit\Quasar;

use FormKit\ComponentNode;

class QRouteTab extends ComponentNode
{

    function to(string $to)
    {
        $this->setAttribute('to', $to);
        return $this;
    }

    function name(string $name)
    {
        $this->setAttribute('name', $name);
        return $this;
    }

    function label(string $label)
    {
        $this->setAttribute('label', $label);
        return $this;
    }

    function icon(string $icon)
    {
        $this->setAttribute('icon', $icon);
        return $this;
    }

    function setAttribute($name, $value)
    {
        $this->attributes[$name] = $value;
    }
}
