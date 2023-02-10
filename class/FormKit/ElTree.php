<?php

namespace FormKit;

class ElTree extends ComponentBaseNode
{
    public function __construct()
    {
        parent::__construct("ElTree", [], null);
    }


    /**
     * tree data
     */
    public function data(array $data)
    {
        $this->props['data'] = $data;
        return $this;
    }

    /**
     * text displayed when data is void
     */
    public function emptyText(string $emptyText)
    {
        $this->props['empty-text'] = $emptyText;
        return $this;
    }

    /**
     * unique identity key name for nodes, its value should be unique across the whole tree
     */
    public function nodeKey(string $nodeKey)
    {
        $this->props['node-key'] = $nodeKey;
        return $this;
    }

    /**
     * props
     */
    public function props(array $props)
    {
        $this->props['props'] = $props;
        return $this;
    }

    /**
     * whether current node is highlighted
     */
    public function highlightCurrent(bool $highlightCurrent = true)
    {
        $this->props['highlight-current'] = $highlightCurrent;
        return $this;
    }

    /**
     * whether to expand all nodes by default
     */
    public function defaultExpandAll(bool $defaultExpandAll = true)
    {
        $this->props['default-expand-all'] = $defaultExpandAll;
        return $this;
    }

    /**
     * whether to expand or collapse node when clicking on the node, if false, then expand or collapse node only when clicking on the arrow icon.
     */
    public function expandOnClickNode(bool $expandOnClickNode = true)
    {
        $this->props['expand-on-click-node'] = $expandOnClickNode;
        return $this;
    }

    /**
     * whether to check or uncheck node when clicking on the node, if false, the node can only be checked or unchecked by clicking on the checkbox.
     */
    public function checkOnClickNode(bool $checkOnClickNode = true)
    {
        $this->props['check-on-click-node'] = $checkOnClickNode;
        return $this;
    }

    /**
     * whether to expand father node when a child node is expanded
     */
    public function autoExpandParent(bool $autoExpandParent = true)
    {
        $this->props['auto-expand-parent'] = $autoExpandParent;
        return $this;
    }

    /**
     * array of keys of initially expanded nodes
     */
    public function defaultExpandedKeys(array $defaultExpandedKeys)
    {
        $this->props['default-expanded-keys'] = $defaultExpandedKeys;
        return $this;
    }

    /**
     * whether to show checkbox
     */
    public function showCheckbox(bool $showCheckbox = true)
    {
        $this->props['show-checkbox'] = $showCheckbox;
        return $this;
    }

    /**
     * whether checked state of a node not affects its father and child nodes when show-checkbox is true
     */
    public function checkStrictly(bool $checkStrictly = true)
    {
        $this->props['check-strictly'] = $checkStrictly;
        return $this;
    }

    /**
     * array of keys of initially checked nodes
     */
    public function defaultCheckedKeys(array $defaultCheckedKeys)
    {
        $this->props['default-checked-keys'] = $defaultCheckedKeys;
        return $this;
    }

    /**
     * key of initially selected node
     */
    public function currentNodeKey(string $currentNodeKey)
    {
        $this->props['current-node-key'] = $currentNodeKey;
        return $this;
    }

    /**
     * whether only one node among the same level can be expanded at one time
     */
    public function accordion(bool $accordion = true)
    {
        $this->props['accordion'] = $accordion;
        return $this;
    }

    /**
     * horizontal indentation of nodes in adjacent levels in pixels
     */
    public function indent(int $indent)
    {
        $this->props['indent'] = $indent;
        return $this;
    }

    /**
     * custom tree node icon component
     */
    public function icon(string $icon)
    {
        $this->props['icon'] = $icon;
        return $this;
    }

    /**
     * whether enable tree nodes drag and drop
     */
    public function draggable(bool $draggable = true)
    {
        $this->props['draggable'] = $draggable;
        return $this;
    }
}
