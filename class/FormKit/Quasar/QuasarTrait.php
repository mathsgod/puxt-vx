<?php

namespace FormKit\Quasar;

trait QuasarTrait
{
    function addQBtn()
    {
        $btn = new QBtn([], $this->translator);
        $this->children[] = $btn;
        return $btn;
    }

    function addQToolbar()
    {
        $toolbar = new QToolbar([], $this->translator);
        $this->children[] = $toolbar;
        return $toolbar;
    }

    function addQCard()
    {
        $card = new QCard([], $this->translator);
        $this->children[] = $card;
        return $card;
    }

    function addQItem()
    {
        $item = new QItem([], $this->translator);
        $this->children[] = $item;
        return $item;
    }

    function addQList()
    {
        $list = new QList([], $this->translator);
        $this->children[] = $list;
        return $list;
    }

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

    function addQBadge()
    {
        $badge = new QBadge([], $this->translator);
        $this->children[] = $badge;
        return $badge;
    }
}
