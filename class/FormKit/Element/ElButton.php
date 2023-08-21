<?php

namespace FormKit\Element;

use FormKit\ComponentNode;

class ElButton extends ComponentNode
{
    function size(string $size)
    {
        $this->setAttribute('size', $size);
        return $this;
    }

    function text(bool $text)
    {
        $this->setAttribute('text', $text);
        return $this;
    }

    function bg(bool $bg)
    {
        $this->setAttribute('bg', $bg);
        return $this;
    }

    function link(bool $bg)
    {
        $this->setAttribute('link', $bg);
        return $this;
    }

    function type(string $type)
    {
        $this->setAttribute('type', $type);
        return $this;
    }

    function plain(bool $plain)
    {
        $this->setAttribute('plain', $plain);
        return $this;
    }

    function round(bool $round)
    {
        $this->setAttribute('round', $round);
        return $this;
    }

    function icon(string $icon)
    {
        $this->setAttribute('icon', $icon);
        return $this;
    }

    function circle(bool $circle)
    {
        $this->setAttribute('circle', $circle);
        return $this;
    }

    function disabled(bool $disabled)
    {
        $this->setAttribute('disabled', $disabled);
        return $this;
    }

    function loading(bool $loading)
    {
        $this->setAttribute('loading', $loading);

        return $this;
    }

    function autofocus(bool $autofocus)
    {
        $this->setAttribute('autofocus', $autofocus);
        return $this;
    }

    function nativeType(string $nativeType)
    {
        $this->setAttribute('native-type', $nativeType);
        return $this;
    }
}
