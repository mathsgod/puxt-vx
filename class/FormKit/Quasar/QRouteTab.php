<?php

namespace FormKit\Quasar;

use FormKit\ComponentNode;

class QRouteTab extends ComponentNode
{
    public function __construct(array $property = [])
    {
        parent::__construct("QRouteTab", $property);
    }

    function to(string $to)
    {
        $this->props['to'] = $to;
        return $this;
    }

    function name(string $name)
    {
        $this->props['name'] = $name;
        return $this;
    }

    function label(string $label)
    {
        $this->props['label'] = $label;
        return $this;
    }

    function icon(string $icon)
    {
        $this->props['icon'] = $icon;
        return $this;
    }
}
