<?php

namespace FormKit\VX;

use FormKit\FormKitInputs;

class Tree extends \FormKit\Element\Inputs\ElInputNode
{
    /**
     * tree data
     */
    public function data(array $data)
    {
        $this->setAttribute('data', $data);
        return $this;
    }

    /**
     * text displayed when data is void
     */
    public function emptyText(string $emptyText)
    {
        $this->setAttribute('empty-text', $emptyText);
        return $this;
    }

    /**
     * unique identity key name for nodes, its value should be unique across the whole tree
     */
    public function nodeKey(string $nodeKey)
    {
        $this->setAttribute('node-key', $nodeKey);
        return $this;
    }

    /**
     * props
     */
    public function _props(array $props)
    {
        $this->setAttribute('props', $props);
        return $this;
    }

    /**
     * whether current node is highlighted
     */
    public function highlightCurrent(bool $highlightCurrent = true)
    {
        $this->setAttribute('highlight-current', $highlightCurrent);
        return $this;
    }

    /**
     * whether to expand all nodes by default
     */
    public function defaultExpandAll(bool $defaultExpandAll = true)
    {
        $this->setAttribute('default-expand-all', $defaultExpandAll);
        return $this;
    }

    /**
     * whether to expand or collapse node when clicking on the node, if false, then expand or collapse node only when clicking on the arrow icon.
     */
    public function expandOnClickNode(bool $expandOnClickNode = true)
    {
        $this->setAttribute('expand-on-click-node', $expandOnClickNode);
        return $this;
    }

    /**
     * whether to check or uncheck node when clicking on the node, if false, the node can only be checked or unchecked by clicking on the checkbox.
     */
    public function checkOnClickNode(bool $checkOnClickNode = true)
    {
        $this->setAttribute('check-on-click-node', $checkOnClickNode);
        return $this;
    }

    /**
     * whether to expand father node when a child node is expanded
     */
    public function autoExpandParent(bool $autoExpandParent = true)
    {
        $this->setAttribute('auto-expand-parent', $autoExpandParent);
        return $this;
    }

    /**
     * array of keys of initially expanded nodes
     */
    public function defaultExpandedKeys(array $defaultExpandedKeys)
    {
        $this->setAttribute('default-expanded-keys', $defaultExpandedKeys);
        return $this;
    }

    /**
     * whether to show checkbox
     */
    public function showCheckbox(bool $showCheckbox = true)
    {
        $this->setAttribute('show-checkbox', $showCheckbox);
        return $this;
    }

    /**
     * whether checked state of a node not affects its father and child nodes when show-checkbox is true
     */
    public function checkStrictly(bool $checkStrictly = true)
    {
        $this->setAttribute('check-strictly', $checkStrictly);
        return $this;
    }

    /**
     * array of keys of initially checked nodes
     */
    public function defaultCheckedKeys(array $defaultCheckedKeys)
    {
        $this->setAttribute('default-checked-keys', $defaultCheckedKeys);
        return $this;
    }

    /**
     * key of initially selected node
     */
    public function currentNodeKey(string $currentNodeKey)
    {
        $this->setAttribute('current-node-key', $currentNodeKey);
        return $this;
    }

    /**
     * whether only one node among the same level can be expanded at one time
     */
    public function accordion(bool $accordion = true)
    {
        $this->setAttribute('accordion', $accordion);
        return $this;
    }

    /**
     * horizontal indentation of nodes in adjacent levels in pixels
     */
    public function indent(int $indent)
    {
        $this->setAttribute('indent', $indent);
        return $this;
    }

    /**
     * custom tree node icon component
     */
    public function icon(string $icon)
    {
        $this->setAttribute('icon', $icon);
        return $this;
    }

    /**
     * whether enable tree nodes drag and drop
     */
    public function draggable(bool $draggable = true)
    {
        $this->setAttribute('draggable', $draggable);
        return $this;
    }
}
