<?php

namespace FormKit\Element;

use FormKit\ComponentBaseNode;
use Symfony\Contracts\Translation\TranslatorInterface;


class ElImage extends ComponentBaseNode
{
    function src(string $src)
    {
        $this->setAttribute('src', $src);
        return $this;
    }

    function fit(string $fit)
    {
        $this->setAttribute('fit', $fit);
        return $this;
    }

    function hideOnClickModal(bool $value = true)
    {
        if ($value) {
            $this->setAttribute('hide-on-click-modal', '');
        } else {
            $this->removeAttribute('hide-on-click-modal');
        }
        return $this;
    }

    function loading(string $loading)
    {
        $this->setAttribute('loading', $loading);
        return $this;
    }

    function lazy(bool $value = true)
    {
        if ($value) {
            $this->setAttribute('lazy', '');
        } else {
            $this->removeAttribute('lazy');
        }
        return $this;
    }

    function scrollContainer(string $scrollContainer)
    {
        $this->setAttribute('scroll-container', $scrollContainer);
        return $this;
    }

    function alt(string $alt)
    {
        $this->setAttribute('alt', $alt);
        return $this;
    }

    function referrerPolicy(string $referrerPolicy)
    {
        $this->setAttribute('referrer-policy', $referrerPolicy);
        return $this;
    }

    function previewSrcList(array $previewSrcList)
    {
        $this->setAttribute(':preview-src-list', json_encode($previewSrcList));
        return $this;
    }

    function zIndex(int $zIndex)
    {
        $this->setAttribute('z-index', $zIndex);
        return $this;
    }

    function initialIndex(int $initialIndex)
    {
        $this->setAttribute('initial-index', $initialIndex);
        return $this;
    }

    function closeOnPressEscape(bool $value = true)
    {
        if ($value) {
            $this->setAttribute('close-on-press-escape', '');
        } else {
            $this->removeAttribute('close-on-press-escape');
        }
        return $this;
    }

    function previewTeleported(bool $value = true)
    {
        if ($value) {
            $this->setAttribute('preview-teleported', '');
        } else {
            $this->removeAttribute('preview-teleported');
        }
        return $this;
    }
}
