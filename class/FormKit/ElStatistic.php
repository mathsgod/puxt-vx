<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class ElStatistic extends ComponentNode
{

    public function __construct(array $props = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct("ElStatistic", $props, $translator);
    }

    /**
     * Setting the decimal point
     */
    function decimalSperation(string $decimalSperation)
    {
        $this->setProp('decimal-seperation', $decimalSperation);
        return $this;
    }

    /**
     * Sets the thousandth identifier
     */
    function groupSperation(string $groupSperation)
    {
        $this->setProp('group-seperation', $groupSperation);
        return $this;
    }

    /**
     * numerical precision
     */
    function precision(int $precision)
    {
        $this->setProp('precision', $precision);
        return $this;
    }

    /**
     * Sets the prefix of a number
     */
    function prefix(string $prefix)
    {
        $this->setProp('prefix', $prefix);
        return $this;
    }

    /**
     * Sets the suffix of a number
     */
    function suffix(string $suffix)
    {
        $this->setProp('suffix', $suffix);
        return $this;
    }

    /**
     * Numeric titles
     */
    function title(string $title)
    {
        $this->setProp('title', $title);
        return $this;
    }

    /**
     * Styles numeric values
     */
    function valueStyle(string|array $valueStyle)
    {
        $this->setProp('value-style', $valueStyle);
        return $this;
    }
}
