<?php

namespace FormKit\Quasar;

use FormKit\ComponentNode;

class QRouteTab extends ComponentNode
{

    function to(string $to)
    {
        $this->attributes['to'] = $to;
        return $this;
    }

    function name(string $name)
    {
        $this->attributes['name'] = $name;
        return $this;
    }

    function label(string $label)
    {
        $this->attributes['label'] = $label;
        return $this;
    }

    function icon(string $icon)
    {
        $this->attributes['icon'] = $icon;
        return $this;
    }
}
