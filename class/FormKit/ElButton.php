<?php

namespace FormKit;

class ElButton extends ComponentBaseNode
{
    public function __construct()
    {
        parent::__construct("ElButton");
    }

    function size(string $size)
    {
        $this->props['size'] = $size;
        return $this;
    }

    function text(bool $text)
    {
        $this->props['text'] = $text;
        return $this;
    }

    function bg(bool $bg)
    {
        $this->props['bg'] = $bg;
        return $this;
    }

    function link(bool $bg)
    {
        $this->props['link'] = $bg;
        return $this;
    }

    function type(string $type)
    {
        $this->props['type'] = $type;
        return $this;
    }

    function plain(bool $plain)
    {
        $this->props['plain'] = $plain;
        return $this;
    }

    function round(bool $round)
    {
        $this->props['round'] = $round;
        return $this;
    }

    function icon(string $icon)
    {
        $this->props['icon'] = $icon;
        return $this;
    }

    function circle(bool $circle)
    {
        $this->props['circle'] = $circle;
        return $this;
    }

    function disabled(bool $disabled)
    {
        $this->props['disabled'] = $disabled;
        return $this;
    }

    function loading(bool $loading)
    {
        $this->props['loading'] = $loading;
        return $this;
    }

    function autofocus(bool $autofocus)
    {
        $this->props['autofocus'] = $autofocus;
        return $this;
    }

    function nativeType(string $nativeType)
    {
        $this->props['nativeType'] = $nativeType;
        return $this;
    }
}
