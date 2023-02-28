<?php

namespace FormKit\Quasar;

use FormKit\ComponentBaseNode;

class QTabs extends ComponentBaseNode
{
    public function __construct(array $property = [])
    {
        parent::__construct("QTabs", $property);
    }

    function addRouteTab()
    {
        $tab = new QRouteTab();
        $this->children[] = $tab;
        return $tab;
    }
}
