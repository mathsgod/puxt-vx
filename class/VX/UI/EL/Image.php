<?php

namespace VX\UI\EL;

use P\HTMLElement;
use P\HTMLTemplateElement;

class Image extends HTMLElement
{
    public function __construct()
    {
        parent::__construct("el-image");
    }


    /**
     * set image src
     */
    function setSrc(string $src)
    {
        $this->setAttribute("src", $src);
    }

    /**
     * set image fit fill / contain / cover / none / scale-down
     */
    function setFit(string $fit)
    {
        $this->setAttribute("fit", $fit);
    }

    /**
     * set image alt
     */
    function setAlt(string $alt)
    {
        $this->setAttribute("alt", $alt);
    }

    /**
     * set referrer policy
     */
    function setReferrerPolicy(string $referrerPolicy)
    {
        $this->setAttribute("referrer-policy", $referrerPolicy);
    }

    /**
     * set lazy
     */
    function setLazy(bool $lazy)
    {
        $this->setAttribute("lazy", $lazy);
    }

    /**
     * set scroll-container
     */
    function setScrollContainer(string $scrollContainer)
    {
        $this->setAttribute("scroll-container", $scrollContainer);
    }

    /**
     * set preview-src-list
     */
    function setPreviewSrcList(array $previewSrcList)
    {
        $this->setAttribute(":preview-src-list", json_encode($previewSrcList, JSON_UNESCAPED_UNICODE));
    }

    /**
     * set z-index
     */
    function setZIndex(int $zIndex)
    {
        $this->setAttribute("z-index", $zIndex);
    }

    /**
     * set placeholder slot
     */
    function setPlaceholder(callable $callable)
    {
        $template = new HTMLTemplateElement;
        $this->append($template);
        $template->setAttribute("slot", "placeholder");
        $callable($template);
    }

    /**
     * set error slot
     */
    function setError(callable $callable)
    {
        $template = new HTMLTemplateElement;
        $this->append($template);
        $template->setAttribute("slot", "error");
        $callable($template);
    }
}
