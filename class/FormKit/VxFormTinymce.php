<?php

namespace FormKit;

class VxFormTinymce extends FormKitInputs
{

    public function apiKey(string $apiKey)
    {
        $this->setAttribute('api-key', $apiKey);
        return $this;
    }

    public function height(string $height)
    {
        $this->setAttribute('height', $height);
        return $this;
    }

    public function accept(string $accept)
    {
        $this->setAttribute('accept', $accept);
        return $this;
    }

    public function baseUrl(string $baseUrl)
    {
        $this->setAttribute('base-url', $baseUrl);
        return $this;
    }

    public function allowAllHtmlTag(bool $allowAllHtmlTag)
    {
        $this->setAttribute('allow-all-html-tag', $allowAllHtmlTag);
        return $this;
    }
}
