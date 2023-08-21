<?php

namespace FormKit\Element;

use FormKit\ComponentBaseNode;
use Symfony\Contracts\Translation\TranslatorInterface;

class ElTabs extends ComponentBaseNode
{
    function addTabPane(): ElTabPane
    {
        return $this->appendHTML('<el-tab-pane></el-tab-pane>')[0];
    }

    function addPane(?string $label = null)
    {
        $pane = $this->addTabPane();
        if ($label) {
            $pane->label($label);
        }
        return $pane;
    }

    /**
     * type of Tab
     */
    function type(string $type)
    {
        $this->setAttribute('type', $type);
        return $this;
    }

    /**
     * whether Tab is closable
     */
    function closable(bool $closable = true)
    {
        $this->setAttribute('closable', $closable);
        return $this;
    }

    /**
     * whether Tab is addable
     */
    function addable(bool $addable = true)
    {
        $this->setAttribute('addable', $addable);
        return $this;
    }

    /**
     * whether Tab is addable and closable
     */
    function editable(bool $editable = true)
    {
        $this->setAttribute('editable', $editable);
        return $this;
    }

    /**
     * position of tabs
     */
    function tabPosition(string $tabPosition)
    {
        $this->setAttribute('tab-position', $tabPosition);
        return $this;
    }

    /**
     * whether width of tab automatically fits its container
     */
    function stretch(bool $stretch = true)
    {
        $this->setAttribute('stretch', $stretch);
        return $this;
    }
}
