<?php

namespace FormKit;

class VxFormCodeInput extends FormKitNode
{
    public function __construct($props = [])
    {
        parent::__construct('FormCodeInput', $props);
    }

    /**
     * language can be: php, javascript, html, css, json, xml, yaml, markdown, sql, c, cpp, csharp, java, python, bash, diff, ini, nginx, makefile, plaintext, powershell, ruby, rust, typescript, vbnet, xml, yaml
     */
    public function language($language)
    {
        $this->setProperty('language', $language);
        return $this;
    }

    public function height(string $height)
    {
        $this->setProperty('height', $height);
        return $this;
    }
}
