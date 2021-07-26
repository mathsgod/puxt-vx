<?php

namespace VX\UI;

use P\HTMLElement;
use VX\TranslatorAwareInterface;
use VX\TranslatorAwareTrait;

class ViewItem extends HTMLElement implements TranslatorAwareInterface
{
    use TranslatorAwareTrait;

    public function __construct()
    {
        parent::__construct("vx-view-item");
    }

    public function setLabel(string $label)
    {
        $this->setAttribute("label", $this->translator->trans($label));
        return $this;
    }

    public function setContent(string $content)
    {
        $this->innerHTML = $content;
        return $this;
    }
}
