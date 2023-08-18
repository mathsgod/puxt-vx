<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class VxTable extends ComponentBaseNode
{

    public function query(string $query)
    {
        $this->setAttribute('query', $query);
        return $this;
    }

    public function addActionColumn(): VxActionColumn
    {
        return $this->appendHTML("<vx-table-action-column></vx-table-action-column>")[0];
    }

    public function addColumn(?string $label = null, ?string $prop = null): VxColumn
    {

        $column = $this->appendHTML("<vx-column></vx-column>")[0];

        if ($label) {
            $column->label($label);
        }

        if ($prop) {
            $column->prop($prop);
        }
        return $column;
    }
}
