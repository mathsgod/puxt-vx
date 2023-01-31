<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class VxTable extends ComponentBaseNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct("VxTable", $property, $translator);
    }

    public function query(string $query)
    {
        $this->setProp('query', $query);
        return $this;
    }

    public function addActionColumn()
    {
        $column = new VxActionColumn([], $this->translator);
        $this->children[] = $column;
        return $column;
    }

    public function addColumn(?string $label = null, ?string $prop = null)
    {
        $column = new VxColumn([], $this->translator);

        if ($label) {
            $column->label($label);
        }

        if ($prop) {
            $column->prop($prop);
        }

        $this->children[] = $column;
        return $column;
    }
}
