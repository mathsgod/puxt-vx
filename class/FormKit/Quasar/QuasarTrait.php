<?php

namespace FormKit\Quasar;

trait QuasarTrait
{
    function addQBtn(): QBtn
    {
        return $this->appendHTML('<q-btn></q-btn>')[0];
    }

    function addQToolbar(): QToolbar
    {
        return $this->appendHTML('<q-toolbar></q-toolbar>')[0];
    }

    function addQCard(): QCard
    {
        $card = $this->appendHTML('<q-card></q-card>')[0];
        $card->flat()->bordered();
        return $card;
    }

    function addQItem(): QItem
    {
        return $this->appendHTML('<q-item></q-item>')[0];
    }

    function addQList(): QList
    {
        $list = $this->appendHTML('<q-list></q-list>')[0];
        $list->separator();
        return $list;
    }

    function addQTabs(): QTabs
    {
        return $this->appendHTML('<q-tabs></q-tabs>')[0];
    }

    function addQIcon(?string $name = null): QIcon
    {
        $icon = $this->appendHTML('<q-icon></q-icon>')[0];
        if ($name) {
            $icon->name($name);
        }
        return $icon;
    }

    function addQTable(): QTable
    {
        return $this->appendHTML('<q-table></q-table>')[0];
    }

    function addQBadge(): QBadge
    {
        return $this->appendHTML('<q-badge></q-badge>')[0];
    }
}
