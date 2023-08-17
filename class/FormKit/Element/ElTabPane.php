<?php

namespace FormKit\Element;

use FormKit\ComponentNode;
use Symfony\Contracts\Translation\TranslatorInterface;

class ElTabPane extends ComponentNode
{
    /**
     * title of the tab
     */
    public function label(string $label)
    {
        $this->setProp('label', $label);
        return $this;
    }

    /**
     * whether Tab is disabled
     */
    public function disabled(bool $disabled = true)
    {
        $this->setProp('disabled', $disabled);
        return $this;
    }

    /**
     * identifier corresponding to the name of Tabs, representing the alias of the tab-pane
     */
    public function name(string $name)
    {
        $this->setProp('name', $name);
        return $this;
    }

    /**
     * whether Tab is closable
     */
    public function closable(bool $closable = true)
    {
        $this->setProp('closable', $closable);
        return $this;
    }

    /**
     * whether Tab is lazy rendered
     */
    public function lazy(bool $lazy = true)
    {
        $this->setProp('lazy', $lazy);
        return $this;
    }
}
