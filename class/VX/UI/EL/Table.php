<?php

namespace VX\UI\EL;

use iterable;
use P\HTMLElement;
use P\HTMLTemplateElement;
use Traversable;

class Table extends HTMLElement
{
    const SIZE_MINI = "mini";
    const SIZE_SMALL = "small";
    const SIZE_MEDIUM = "medium";
    const SIZE_LARGE = "large";

    function __construct()
    {
        parent::__construct("el-table");
    }

    /**
     * Table data
     */
    function setData(iterable $data)
    {
        if ($data instanceof iterable) {
            $data = iterator_to_array($data);
        }
        $this->setAttribute(":data", json_encode($data, JSON_UNESCAPED_UNICODE));
        return $this;
    }

    /**
     * Table's height. By default it has an auto height. If its value is a number, the height is measured in pixels; if its value is a string, the value will be assigned to element's style.height, the height is affected by external styles
     */
    function setHeight(string|int $height)
    {
        if (is_string($height)) {
            $this->setAttribute("height", $height);
        } else {
            $this->setAttribute(":height", $height);
        }
    }

    /**
     * Table's max-height. The legal value is a number or the height in px.
     */
    function setMaxHeight(string|int $height)
    {
        if (is_string($height)) {
            $this->setAttribute("max-height", $height);
        } else {
            $this->setAttribute(":max-height", $height);
        }
    }

    /**
     * whether Table is striped
     */
    function setStripe(bool $strip)
    {
        $this->setAttribute("strip", $strip);
    }

    /**
     * whether Table has vertical border
     */
    public function setBorder(bool $border)
    {
        $this->setAttribute("border", $border);
    }

    /**
     * size of Table
     * medium / small / mini / large
     */
    function setSize(string $size)
    {
        $this->setAttribute("size", $size);
    }

    /**
     * whether width of column automatically fits its container
     */
    function setFit(bool $fit)
    {
        $this->setAttribute("fit", $fit);
    }

    /**
     * whether Table header is visible
     */
    function setShowHeader(bool $show)
    {
        $this->setAttribute("show-header", $show);
    }

    /**
     * whether current row is highlighted
     */
    function setHighlightCurrentRow(bool $highlight)
    {
        $this->setAttribute("highlight-current-row", $highlight);
    }

    /**
     * key of current row, a set only prop
     */
    function setCurrentRowKey(string|int $key)
    {
        if (is_string($key)) {
            $this->setAttribute("current-row-key", $key);
        } else {
            $this->setAttribute(":current-row-key", $key);
        }
    }

    /**
     * function that returns custom class names for a row, or a string assigning class names for every row
     */
    function setRowClassName(string $name)
    {
        $this->setAttribute("row-class-name", $name);
    }

    /**
     * function that returns custom style for a row, or an object assigning custom style for every row
     */
    function setRowStyle(array $style)
    {
        $this->setAttribute(":row-style", json_encode($style, JSON_UNESCAPED_UNICODE));
    }

    /**
     * function that returns custom class names for a cell, or a string assigning class names for every cell
     */
    function setCellClassName(string $name)
    {
        $this->setAttribute("cell-class-name", $name);
    }

    /**
     * function that returns custom style for a cell, or an object assigning custom style for every cell
     */
    function setCellStyle(array $style)
    {
        $this->setAttribute(":cell-style", json_encode($style, JSON_UNESCAPED_UNICODE));
    }

    /**
     * function that returns custom class names for a row in table header, or a string assigning class names for every row in table header
     */
    function setHeaderRowClassName(string $name)
    {
        $this->setAttribute("header-row-class-name", $name);
    }

    /**
     * function that returns custom style for a row in table header, or an object assigning custom style for every row in table header
     */
    function setHeaderRowStyle(array $style)
    {
        $this->setAttribute(":header-row-style", json_encode($style, JSON_UNESCAPED_UNICODE));
    }

    /**
     * function that returns custom class names for a cell in table header, or a string assigning class names for every cell in table header
     */
    function setHeaderCellName(string $name)
    {
        $this->setAttribute("header-cell-name", $name);
    }

    /**
     * function that returns custom style for a cell in table header, or an object assigning custom style for every cell in table header
     */
    function setHeaderCellStyle(array $style)
    {
        $this->setAttribute(":header-cell-style", json_encode($style, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 	key of row data, used for optimizing rendering. Required if reserve-selection is on or display tree data. When its type is String, multi-level access is supported, e.g. user.info.id, but user.info[0].id is not supported, in which case Function should be used.
     */
    function setRowKey(string $key)
    {
        $this->setAttribute("row-key", $key);
    }

    /**
     * Displayed text when data is empty. You can customize this area with slot="empty"
     */
    function setEmptyText(string $string)
    {
        $this->setAttribute("empty-text", $string);
    }

    /**
     * whether expand all rows by default, works when the table has a column type="expand" or contains tree structure data
     */
    function setDefaultExpandAll(bool $expand)
    {
        $this->setAttribute("default-expand-all", $expand);
    }

    /**
     * set expanded rows by this prop, prop's value is the keys of expand rows, you should set row-key before using this prop
     */
    function setExpandRowKeys(array $keys)
    {
        $this->setAttribute(":expand-row-keys", json_encode($keys, JSON_UNESCAPED_UNICODE));
    }

    /**
     * set the default sort column and order. property prop is used to set default sort column, property order is used to set default sort order
     * order: ascending, descending
     */
    function setDefaultSort(array $sort)
    {
        $this->setAttribute(":default-sort", json_encode($sort, JSON_UNESCAPED_UNICODE));
    }

    /**
     * tooltip effect property
     * dark/light
     */
    function setTooltipEffect(string $effect)
    {
        $this->setAttribute("tooltip-effect", $effect);
    }

    /**
     * whether to display a summary row
     */
    function setShowSummary(bool $show)
    {
        $this->setAttribute("show-summary", $show);
    }

    /**
     * displayed text for the first column of summary row
     */
    function setSumText(string $text)
    {
        $this->setAttribute("sum-text", $text);
    }


    /**
     * controls the behavior of master checkbox in multi-select tables when only some rows are selected (but not all). If true, all rows will be selected, else deselected.
     */
    function setSelectOnIndeteminate(bool $value)
    {
        $this->setAttribute("select-on-indeterminate", $value);
    }

    /**
     * horizontal indentation of tree data
     */
    function setIndent(string $indent)
    {
        $this->setAttribute(":indent", $indent);
    }

    /**
     * whether to lazy loading data
     */
    function setLazy(bool $lazy)
    {
        $this->setAttribute("lazy", $lazy);
    }

    function setTreeProps(array $data)
    {
        $this->setAttribute(":tree-props", json_encode($data, JSON_UNESCAPED_UNICODE));
    }

    function setAppendTemplate(callable $callback)
    {
        $template = new HTMLTemplateElement;
        $template->setAttribute("v-slot:append", "");
        $this->append($template);
        $callback($template);
    }

    public function addColumn(?string $label = null, ?string $prop = null)
    {
        $column = new TableColumn;
        $this->append($column);
        if ($label) {
            $column->setLabel($label);
        }

        if ($prop) {
            $column->setProp($prop);
        }

        return $column;
    }
}
