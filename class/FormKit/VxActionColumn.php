<?php

namespace FormKit;


class VxActionColumn extends ComponentBaseNode
{
    public function __construct(array $property = [])
    {
        parent::__construct("VxTableActionColumn", $property);
    }

    public function showDelete()
    {
        $this->setProp('delete', true);
        return $this;
    }

    public function showEdit()
    {
        $this->setProp('edit', true);
        return $this;
    }

    public function showView()
    {
        $this->setProp('view', true);
        return $this;
    }
}
