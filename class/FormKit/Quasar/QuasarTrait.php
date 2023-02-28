<?php

namespace FormKit\Quasar;

trait QuasarTrait
{
    function addQTabs()
    {
        $tabs = new QTabs([], $this->translator);
        $this->children[] = $tabs;
        return $tabs;
    }

    function addQIcon(?string $name = null)
    {
        $icon = new QIcon([]);
        if ($name) {
            $icon->name($name);
        }
        $this->children[] = $icon;
        return $icon;
    }

    function addQTable()
    {
        $table = new QTable([], $this->translator);
        $this->children[] = $table;
        return $table;
    }
}
