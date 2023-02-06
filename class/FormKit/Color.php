<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class Color extends InputNode
{
    protected $translator;


    public function __construct(?TranslatorInterface $translator = null)
    {
        $this->translator = $translator;
        $this->property = array_merge([
            '$formkit' => "color"
        ]);
    }
}
