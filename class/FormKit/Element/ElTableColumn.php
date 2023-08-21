<?php

namespace FormKit\Element;

use FormKit\ComponentNode;
use Symfony\Contracts\Translation\TranslatorInterface;

class ElTableColumn extends ComponentNode
{

    public function addColumn(): ElTableColumn
    {
        return $this->appendHTML('<el-table-column></el-table-column>')[0];
    }

    /**
     * type of the column. If set to selection, the column will display checkbox. If set to index, the column will display index of the row (staring from 1). If set to expand, the column will display expand icon.
     */
    public function type(string $type)
    {
        $this->setAttribute('type', $type);
        return $this;
    }

    /**
     * customize indices for each row, works on columns with type=index
     */
    public function index(int $index)
    {
        $this->setAttribute('index', $index);
        return $this;
    }

    /**
     * column label
     */
    public function label(string $label)
    {
        $this->setAttribute('label', $label);
        return $this;
    }

    /**
     * column's key. If you need to use the filter-change event, you need this attribute to identify which column is being filtered
     */
    public function columnKey(string $columnKey)
    {
        $this->setAttribute('column-key', $columnKey);
        return $this;
    }

    /**
     * field name. You can also use its alias: property
     */
    public function prop(string $prop)
    {
        $this->setAttribute('prop', $prop);
        return $this;
    }

    /**
     * column width
     */
    public function width(string|int $width)
    {
        $this->setAttribute('width', $width);
        return $this;
    }

    /**
     * column minimum width. Columns with width has a fixed width, while columns with min-width has a width that is distributed in proportion
     */
    public function minWidth(string|int $minWidth)
    {
        $this->setAttribute('min-width', $minWidth);
        return $this;
    }

    /**
     * whether column is fixed at left / right. Will be fixed at left if true
     */
    public function fixed(string|bool $fixed)
    {
        $this->setAttribute('fixed', $fixed);
        return $this;
    }

    /**
     * whether column can be sorted. Remote sorting can be done by setting this attribute to 'custom' and listening to the sort-change event of Table
     */
    public function sortable(bool $sortable = true)
    {
        $this->setAttribute('sortable', $sortable);
        return $this;
    }

    /**
     * the order of the sorting strategies used when sorting the data, works when sortable is true. Accepts an array, as the user clicks on the header, the column is sorted in order of the elements in the array
     */
    public function sortOrders(array $sortOrders)
    {
        $this->setAttribute('sort-orders', $sortOrders);
        return $this;
    }

    /**
     * whether column width can be resized, works when border of el-table is true
     */
    public function resizable(bool $resizable = true)
    {
        $this->setAttribute('resizable', $resizable);
        return $this;
    }

    /**
     * whether to hide extra content and show them in a tooltip when hovering on the cell
     */
    public function showOverflowTooltip(bool $showOverflowTooltip = true)
    {
        $this->setAttribute('show-overflow-tooltip', $showOverflowTooltip);
        return $this;
    }

    /**
     * alignment
     */
    public function align(string $align)
    {
        $this->setAttribute('align', $align);
        return $this;
    }

    /**
     * alignment of the table header. If omitted, the value of the above align attribute will be applied
     */
    public function headerAlign(string $headerAlign)
    {
        $this->setAttribute('header-align', $headerAlign);
        return $this;
    }

    /**
     * class name of cells in the column
     */
    public function className(string $className)
    {
        $this->setAttribute('class-name', $className);
        return $this;
    }

    /**
     * class name of the label of this column
     */
    public function labelClassName(string $labelClassName)
    {
        $this->setAttribute('label-class-name', $labelClassName);
        return $this;
    }

    /**
     * whether to reserve selection after data refreshing, works when type is 'selection'. Note that row-key is required for this to work
     */
    public function reserveSelection(bool $reserveSelection = true)
    {
        $this->setAttribute('reserve-selection', $reserveSelection);
        return $this;
    }
}
