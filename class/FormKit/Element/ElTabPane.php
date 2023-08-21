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
        $this->setAttribute('label', $label);
        return $this;
    }

    /**
     * whether Tab is disabled
     */
    public function disabled(bool $disabled = true)
    {
        $this->setAttribute('disabled', $disabled);
        return $this;
    }

    /**
     * identifier corresponding to the name of Tabs, representing the alias of the tab-pane
     */
    public function name(string $name)
    {
        $this->setAttribute('name', $name);
        return $this;
    }

    /**
     * whether Tab is closable
     */
    public function closable(bool $closable = true)
    {
        $this->setAttribute('closable', $closable);
        return $this;
    }

    /**
     * whether Tab is lazy rendered
     */
    public function lazy(bool $lazy = true)
    {
        $this->setAttribute('lazy', $lazy);
        return $this;
    }
}
