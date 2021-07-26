<?php

namespace VX;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class TwigI18n extends AbstractExtension
{
    public function getFilters()
    {
        return [new TwigFilter("t", [$this, "translate"])];
    }

    public function translate($s)
    {
        return "A";
    }
}
