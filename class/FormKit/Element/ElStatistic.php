<?php

namespace FormKit\Element;

use FormKit\ComponentNode;
use Symfony\Contracts\Translation\TranslatorInterface;

class ElStatistic extends ComponentNode
{


    /**
     * Setting the decimal point
     */
    function decimalSperation(string $decimalSperation)
    {
        $this->setAttribute('decimal-seperation', $decimalSperation);
        return $this;
    }

    /**
     * Sets the thousandth identifier
     */
    function groupSperation(string $groupSperation)
    {
        $this->setAttribute('group-seperation', $groupSperation);
        return $this;
    }

    /**
     * numerical precision
     */
    function precision(int $precision)
    {
        $this->setAttribute('precision', $precision);
        return $this;
    }

    /**
     * Sets the prefix of a number
     */
    function prefix(string $prefix)
    {
        $this->setAttribute('prefix', $prefix);
        return $this;
    }

    /**
     * Sets the suffix of a number
     */
    function suffix(string $suffix)
    {
        $this->setAttribute('suffix', $suffix);
        return $this;
    }

    /**
     * Numeric titles
     */
    function title(string $title)
    {
        $this->setAttribute('title', $title);
        return $this;
    }

    /**
     * Styles numeric values
     */
    function valueStyle(string|array $valueStyle)
    {
        $this->setAttribute('value-style', $valueStyle);
        return $this;
    }
}
