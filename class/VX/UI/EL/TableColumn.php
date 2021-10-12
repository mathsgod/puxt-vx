<?php

namespace VX\UI\EL;

use P\HTMLElement;
use P\HTMLTemplateElement;
use Traversable;

class TableColumn extends HTMLElement
{
    function __construct()
    {
        parent::__construct("el-table-column");
    }

    /**
     * type of the column. If set to selection, the column will display checkbox. If set to index, the column will display index of the row (staring from 1). If set to expand, the column will display expand icon.
     */
    function setType(string $type)
    {
        $this->setAttribute("type", $type);
    }


    /**
     * customize indices for each row, works on columns with type=index
     */
    function setIndex(int $index)
    {
        $this->setAttribute(":index", $index);
    }

    /**
     * column label
     */
    function setLabel(string $label)
    {
        $this->setAttribute("label", $label);
    }

    /**
     * column's key. If you need to use the filter-change event, you need this attribute to identify which column is being filtered
     */
    function setColumnKey(string $key)
    {
        $this->setAttribute("column-key", $key);
    }

    /**
     * field name. You can also use its alias: property
     */
    function setProp(string $prop)
    {
        $this->setAttribute("prop", $prop);
    }

    /**
     * column width
     */
    function setWidth(string $width)
    {
        $this->setAttribute("width", $width);
    }

    /**
     * column minimum width. Columns with width has a fixed width, while columns with min-width has a width that is distributed in proportion
     */
    function setMinWidth(string $width)
    {
        $this->setAttribute("min-width", $width);
    }

    /**
     * whether column is fixed at left/right. Will be fixed at left if true
     * true/left/right
     */
    function setFixed(string|bool $fixed)
    {
        $this->setAttribute("fixed", $fixed);
    }

    /**
     * whether column can be sorted. Remote sorting can be done by setting this attribute to 'custom' and listening to the sort-change event of Table
     * true, false, custom
     */
    function setSortable(string|bool $sortable)
    {
        $this->setAttribute("sortable", $sortable);
    }

    /**
     * specify which property to sort by, works when sortable is true and sort-method is undefined. If set to an Array, the column will sequentially sort by the next property if the previous one is equal
     */
    function setSortBy(string $sortBy)
    {
        $this->setAttribute("sort-by", $sortBy);
    }

    /**
     * whether column width can be resized, works when border of el-table is true
     */
    function setResizable(bool $resizable)
    {
        $this->setAttribute("resizable", $resizable);
    }

    /**
     * whether to hide extra content and show them in a tooltip when hovering on the cell	
     */
    function setShowOverflowTooltip(bool $show)
    {
        $this->setAttribute("show-overflow-tooltip", $show);
    }

    /**
     * alignment
     * left/center/right
     */
    function setAlign(string $align)
    {
        $this->setAttribute("align", $align);
    }

    /**
     * alignment of the table header. If omitted, the value of the above align attribute will be applied
     * left/center/right
     */
    function setHeaderAlign(string $align)
    {
        $this->setAttribute("header-align", $align);
    }

    /**
     * class name of cells in the column
     */
    function setClassName(string $name)
    {
        $this->setAttribute("class-name", $name);
    }

    /**
     * class name of the label of this column
     */
    function setLableClassName(string $name)
    {
        $this->setAttribute("label-class-name", $name);
    }

    /**
     * an array of data filtering options. For each element in this array, text and value are required
     * Array[{ text, value }]
     */
    function setFilters(iterable $filters)
    {
        if ($filters instanceof Traversable) {
            $filters = iterator_to_array($filters);
        }
        $this->setAttribute(":filters", json_encode($filters, JSON_UNESCAPED_UNICODE));
    }

    /**
     * placement for the filter dropdown
     * same as Tooltip's placement
     */
    function setFilterPlacement(string $placement)
    {
        $this->setAttribute("filter-placement", $placement);
    }

    /**
     * whether data filtering supports multiple options
     */
    function setFilterMultiple(bool $multiple)
    {
        $this->setAttribute("filter-multiple", $multiple);
    }

    /**
     * 	Custom content for table header. The scope parameter is { column, $index }
     */
    function addHeaderTemplate(callable $callback, string $scope = "scope")
    {
        $template = new HTMLTemplateElement();
        $template->setAttribute("v-slot:header", $scope);
        $callback($template);

        $this->append($template);
    }

    /**
     * Custom content for table columns. The scope parameter is { row, column, $index }
     */
    function addTemplate(callable $callback, string $scope = "scope")
    {
        $template = new HTMLTemplateElement();
        $template->setAttribute("v-slot", $scope);
        $callback($template);

        $this->append($template);

        return $this;
    }
}
