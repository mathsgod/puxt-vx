<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class ElTableColumn extends ComponentNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct('ElTableColumn', $property, $translator);
    }

    /**
     * type of the column. If set to selection, the column will display checkbox. If set to index, the column will display index of the row (staring from 1). If set to expand, the column will display expand icon.
     */
    public function type(string $type)
    {
        $this->setProperty('type', $type);
        return $this;
    }

    /**
     * customize indices for each row, works on columns with type=index
     */
    public function index(int $index)
    {
        $this->setProperty('index', $index);
        return $this;
    }

    /**
     * column label
     */
    public function label(string $label)
    {
        $this->setProperty('label', $label);
        return $this;
    }

    /**
     * column's key. If you need to use the filter-change event, you need this attribute to identify which column is being filtered
     */
    public function columnKey(string $columnKey)
    {
        $this->setProperty('column-key', $columnKey);
        return $this;
    }

    /**
     * field name. You can also use its alias: property
     */
    public function prop(string $prop)
    {
        $this->setProperty('prop', $prop);
        return $this;
    }

    /**
     * column width
     */
    public function width(string|int $width)
    {
        $this->setProperty('width', $width);
        return $this;
    }

    /**
     * column minimum width. Columns with width has a fixed width, while columns with min-width has a width that is distributed in proportion
     */
    public function minWidth(string|int $minWidth)
    {
        $this->setProperty('min-width', $minWidth);
        return $this;
    }

    /**
     * whether column is fixed at left / right. Will be fixed at left if true
     */
    public function fixed(string|bool $fixed)
    {
        $this->setProperty('fixed', $fixed);
        return $this;
    }

    /**
     * whether column can be sorted. Remote sorting can be done by setting this attribute to 'custom' and listening to the sort-change event of Table
     */
    public function sortable(bool $sortable = true)
    {
        $this->setProperty('sortable', $sortable);
        return $this;
    }

    /**
     * the order of the sorting strategies used when sorting the data, works when sortable is true. Accepts an array, as the user clicks on the header, the column is sorted in order of the elements in the array
     */
    public function sortOrders(array $sortOrders)
    {
        $this->setProperty('sort-orders', $sortOrders);
        return $this;
    }

    /**
     * whether column width can be resized, works when border of el-table is true
     */
    public function resizable(bool $resizable = true)
    {
        $this->setProperty('resizable', $resizable);
        return $this;
    }

    /**
     * whether to hide extra content and show them in a tooltip when hovering on the cell
     */
    public function showOverflowTooltip(bool $showOverflowTooltip = true)
    {
        $this->setProperty('show-overflow-tooltip', $showOverflowTooltip);
        return $this;
    }

    /**
     * alignment
     */
    public function align(string $align)
    {
        $this->setProperty('align', $align);
        return $this;
    }

    /**
     * alignment of the table header. If omitted, the value of the above align attribute will be applied
     */
    public function headerAlign(string $headerAlign)
    {
        $this->setProperty('header-align', $headerAlign);
        return $this;
    }

    /**
     * class name of cells in the column
     */
    public function className(string $className)
    {
        $this->setProperty('class-name', $className);
        return $this;
    }

    /**
     * class name of the label of this column
     */
    public function labelClassName(string $labelClassName)
    {
        $this->setProperty('label-class-name', $labelClassName);
        return $this;
    }

    /**
     * whether to reserve selection after data refreshing, works when type is 'selection'. Note that row-key is required for this to work
     */
    public function reserveSelection(bool $reserveSelection = true)
    {
        $this->setProperty('reserve-selection', $reserveSelection);
        return $this;
    }
}
