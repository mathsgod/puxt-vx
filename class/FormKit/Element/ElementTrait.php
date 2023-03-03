<?php

namespace FormKit\Element;

trait ElementTrait
{

    function addElBacktop()
    {
        $component = new ElBacktop([], $this->translator);
        $this->children[] = $component;
        return $component;
    }

    function addElAffix()
    {
        $component = new ElAffix([], $this->translator);
        $this->children[] = $component;
        return $component;
    }

    function addElTimeline()
    {
        $component = new ElTimeline([], $this->translator);
        $this->children[] = $component;
        return $component;
    }

    function addElSkeleton()
    {
        $component = new ElSkeleton([], $this->translator);
        $this->children[] = $component;
        return $component;
    }

    function addElProgress()
    {
        $component = new ElProgress([], $this->translator);
        $this->children[] = $component;
        return $component;
    }

    function addElImage()
    {
        $component = new ElImage([], $this->translator);
        $this->children[] = $component;
        return $component;
    }

    function addElAvatar()
    {
        $component = new ElAvatar([], $this->translator);
        $this->children[] = $component;
        return $component;
    }

    function addElContainer()
    {
        $component = new ElContainer([], $this->translator);
        $this->children[] = $component;
        return $component;
    }

    function addElScrollbar()
    {
        $component = new ElScrollbar([], $this->translator);
        $this->children[] = $component;
        return $component;
    }

    function addElTabs()
    {
        $component = new ElTabs([], $this->translator);
        $this->children[] = $component;
        return $component;
    }

    function addElTable()
    {
        $component = new ElTable([], $this->translator);
        $this->children[] = $component;
        return $component;
    }

    function addElRow()
    {
        $component = new ElRow([], $this->translator);
        $this->children[] = $component;
        return $component;
    }
    function addElCollapse()
    {
        $collapse = new ElCollapse([], $this->translator);
        $this->children[] = $collapse;
        return $collapse;
    }

    function addElResult()
    {
        $result = new ElResult([], $this->translator);
        $this->children[] = $result;
        return $result;
    }

    function addElEmpty()
    {
        $empty = new ElEmpty();
        $this->children[] = $empty;
        return $empty;
    }

    function addElLink()
    {
        $component = new ElLink([], $this->translator);
        $this->children[] = $component;
        return $component;
    }

    function addElSpace()
    {
        $component = new ElSpace([], $this->translator);
        $this->children[] = $component;
        return $component;
    }

    function addElDivider()
    {
        $component = new ElDivider([], $this->translator);
        $this->children[] = $component;
        return $component;
    }

    function addElBadge()
    {
        $badge = new ElBadge([], $this->translator);
        $this->children[] = $badge;
        return $badge;
    }

    function addElDescriptions()
    {
        $component = new ElDescriptions([], $this->translator);
        $this->children[] = $component;
        return $component;
    }

    function addElStatistic()
    {
        $statistic = new ElStatistic([], $this->translator);
        $this->children[] = $statistic;
        return $statistic;
    }

    function addElTag()
    {
        $component = new ElTag([], $this->translator);
        $this->children[] = $component;
        return $component;
    }

    function addElCard()
    {
        $component = new ElCard([], $this->translator);
        $this->children[] = $component;
        return $component;
    }

    function addElButton()
    {
        $component = new ElButton([], $this->translator);
        $this->children[] = $component;
        return $component;
    }

    function addElMenu()
    {
        $menu = new ElMenu([], $this->translator);
        $this->children[] = $menu;
        return $menu;
    }

    function addElCountdown()
    {
        $countdown = new ElCountdown([], $this->translator);
        $this->children[] = $countdown;
        return $countdown;
    }
}
