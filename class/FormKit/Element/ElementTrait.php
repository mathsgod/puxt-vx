<?php

namespace FormKit\Element;

trait ElementTrait
{
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
