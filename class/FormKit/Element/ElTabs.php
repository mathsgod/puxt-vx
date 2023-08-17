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
        $this->setProp('type', $type);
        return $this;
    }

    /**
     * whether Tab is closable
     */
    function closable(bool $closable = true)
    {
        $this->setProp('closable', $closable);
        return $this;
    }

    /**
     * whether Tab is addable
     */
    function addable(bool $addable = true)
    {
        $this->setProp('addable', $addable);
        return $this;
    }

    /**
     * whether Tab is addable and closable
     */
    function editable(bool $editable = true)
    {
        $this->setProp('editable', $editable);
        return $this;
    }

    /**
     * position of tabs
     */
    function tabPosition(string $tabPosition)
    {
        $this->setProp('tab-position', $tabPosition);
        return $this;
    }

    /**
     * whether width of tab automatically fits its container
     */
    function stretch(bool $stretch = true)
    {
        $this->setProp('stretch', $stretch);
        return $this;
    }
}
