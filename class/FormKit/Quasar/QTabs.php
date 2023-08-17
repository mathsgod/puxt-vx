<?php

namespace FormKit\Quasar;

use FormKit\ComponentBaseNode;

class QTabs extends ComponentBaseNode
{

    function addRouteTab(): QRouteTab
    {
        return $this->appendHTML('<q-route-tab></q-route-tab>')[0];
    }
}
