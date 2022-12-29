<?php

namespace VX;

interface StyleableInterface
{
    public function getStyles(): array;
    public function setStyles(array $styles): void;
}
