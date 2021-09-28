<?php

namespace VX;

use Symfony\Contracts\Translation\TranslatorInterface;

interface TranslatorAwareInterface
{
    public function setTranslator(TranslatorInterface $translator);
}
