<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class ElTable extends ComponentNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct('ElTable', $property, $translator);
    }

    public function data($data)
    {
        $this->props['data'] = $data;
        return $this;
    }

    public function addTableColumn()
    {
        $column = new ElTableColumn([], $this->translator);
        $this->children[] = $column;
        return $column;
    }

    public function size(string $size)
    {
        $this->setProperty('size', $size);
        return $this;
    }
}
