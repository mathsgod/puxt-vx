<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class Group extends SchemaNode
{
    public function __construct(?TranslatorInterface $translator = null)
    {
        $this->property = array_merge([
            '$formkit' => "group"
        ]);

        parent::__construct($translator);
    }

}
