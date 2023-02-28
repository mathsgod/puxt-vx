<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class RouterLink extends ComponentNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct("RouterLink", $property, $translator);
    }

    function to(string $to)
    {
        $this->props['to'] = $to;
        return $this;
    }
}
