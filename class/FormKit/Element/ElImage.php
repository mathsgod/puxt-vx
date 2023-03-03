<?php

namespace FormKit\Element;

use FormKit\ComponentBaseNode;
use Symfony\Contracts\Translation\TranslatorInterface;


class ElImage extends ComponentBaseNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct('ElImage', $property, $translator);
    }

    function src(string $src)
    {
        $this->props['src'] = $src;
        return $this;
    }

    function fit(string $fit)
    {
        $this->props['fit'] = $fit;
        return $this;
    }

    function hideOnClickModal(bool $value = true)
    {
        $this->props['hide-on-click-modal'] = $value;
        return $this;
    }

    function loading(string $loading)
    {
        $this->props['loading'] = $loading;
        return $this;
    }

    function lazy(bool $value = true)
    {
        $this->props['lazy'] = $value;
        return $this;
    }

    function scrollContainer(string $scrollContainer)
    {
        $this->props['scroll-container'] = $scrollContainer;
        return $this;
    }

    function alt(string $alt)
    {
        $this->props['alt'] = $alt;
        return $this;
    }

    function referrerPolicy(string $referrerPolicy)
    {
        $this->props['referrer-policy'] = $referrerPolicy;
        return $this;
    }

    function previewSrcList(array $previewSrcList)
    {
        $this->props['preview-src-list'] = $previewSrcList;
        return $this;
    }

    function zIndex(int $zIndex)
    {
        $this->props['z-index'] = $zIndex;
        return $this;
    }

    function initialIndex(int $initialIndex)
    {
        $this->props['initial-index'] = $initialIndex;
        return $this;
    }

    function closeOnPressEscape(bool $value = true)
    {
        $this->props['close-on-press-escape'] = $value;
        return $this;
    }

    function previewTeleported(bool $value = true)
    {
        $this->props['preview-teleported'] = $value;
        return $this;
    }
}
