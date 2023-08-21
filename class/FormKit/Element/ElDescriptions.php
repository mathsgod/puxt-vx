<?php

namespace FormKit\Element;

use FormKit\ComponentNode;

class ElDescriptions extends ComponentNode
{
    public function addItem(?string $label = null, ?string $content = null): ElDescriptionsItem
    {
        $item = $this->appendHTML('<el-descriptions-item></el-descriptions-item>')[0];
        if ($label) {
            $item->label($label);
        }
        if ($content) {
            $item->append($content);
        }
        return $item;
    }

    public function item(?string $label = null, $content = null)
    {
        $item = $this->addItem($label);
        if ($content) {
            $item->append($content);
        }

        return $this;
    }


    public function addDescriptionsItem(?string $label = null)
    {
        $item = $this->appendHTML('<el-descriptions-item></el-descriptions-item>')[0];
        if ($label) {
            $item->label($label);
        }
        return $item;
    }

    /**
     * whether to show the border
     */
    public function border(bool $border = true)
    {
        $this->setAttribute('border', $border);
        return $this;
    }

    public function column(int $column)
    {
        $this->setAttribute('column', $column);
        return $this;
    }

    /**
     * direction of list
     */
    public function direction(string $direction)
    {
        $this->setAttribute('direction', $direction);
        return $this;
    }

    public function size(string $size)
    {
        $this->setAttribute('size', $size);
        return $this;
    }

    /**
     * whether to show the title
     */
    public function title(bool $title = true)
    {
        $this->setAttribute('title', $title);
        return $this;
    }

    public function extra(string $extra)
    {
        $this->setAttribute('extra', $extra);
        return $this;
    }
}
