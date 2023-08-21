<?php

namespace FormKit;

class VxFormCodeInput extends FormKitInputs
{
    /**
     * language can be: php, javascript, html, css, json, xml, yaml, markdown, sql, c, cpp, csharp, java, python, bash, diff, ini, nginx, makefile, plaintext, powershell, ruby, rust, typescript, vbnet, xml, yaml
     */
    public function language($language)
    {
        $this->setAttribute('language', $language);
        return $this;
    }

    public function height(string $height)
    {
        $this->setAttribute('height', $height);

        return $this;
    }
}
