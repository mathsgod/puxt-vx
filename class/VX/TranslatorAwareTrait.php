<?php

namespace VX;

use Symfony\Contracts\Translation\TranslatorInterface;

trait TranslatorAwareTrait
{
    protected $translator = null;

    public function setTranslator(TranslatorInterface $translator = null)
    {
        $this->translator = $translator;
    }
}
