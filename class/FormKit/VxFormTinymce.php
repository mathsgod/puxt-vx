<?php

namespace FormKit;

class VxFormTinymce extends FormKitNode
{
    public function __construct($props = [])
    {
        parent::__construct('FormTinymce', $props);
    }

    public function apiKey(string $apiKey)
    {
        $this->setProperty('api-key', $apiKey);
        return $this;
    }

    public function height(string $height)
    {
        $this->setProperty('height', $height);
        return $this;
    }

    public function accept(string $accept)
    {
        $this->setProperty('accept', $accept);
        return $this;
    }

    public function baseUrl(string $baseUrl)
    {
        $this->setProperty('base-url', $baseUrl);
        return $this;
    }

    public function allowAllHtmlTag(bool $allowAllHtmlTag)
    {
        $this->setProperty('allow-all-html-tag', $allowAllHtmlTag);
        return $this;
    }
}
