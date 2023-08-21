<?php

namespace FormKit;

class ComponentNode extends ComponentBaseNode
{
    use FormKitTrait;

    protected $translator;
    public function addChildren($children)
    {
        return $this->append($children);
    }

    public function children($children)
    {
        $this->append($children);
        return $this;
    }


}
