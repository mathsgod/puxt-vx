<?php

namespace FormKit\Element;

use FormKit\ComponentBaseNode;
use Symfony\Contracts\Translation\TranslatorInterface;

class ElTable extends ComponentBaseNode
{

    public function addColumn(): ElTableColumn
    {
        return $this->appendHTML('<el-table-column></el-table-column>')[0];
    }

    /**
     * Table data
     */
    public function data($data)
    {
        $this->setAttribute('data', $data);
        return $this;
    }

    /**
     * Table's height. By default it has an auto height. If its value is a number, the height is measured in pixels; if its value is a string, the value will be assigned to element's style.height, the height is affected by external styles
     */
    public function height(string|int $height)
    {
        $this->setAttribute('height', $height);
        return $this;
    }

    /**
     * Table's max-height. The legal value is a number or the height in px.
     */
    public function maxHeight(string|int $maxHeight)
    {
        $this->setAttribute('max-height', $maxHeight);
        return $this;
    }

    /**
     * whether Table is striped
     */
    public function stripe(bool $stripe = true)
    {
        $this->setAttribute('stripe', $stripe);
        return $this;
    }

    /**
     * whether Table has vertical border
     */
    public function border(bool $border = true)
    {
        $this->setAttribute('border', $border);
        return $this;
    }

    /**
     * size of Table
     */
    public function size(string $size)
    {
        $this->setAttribute('size', $size);
        return $this;
    }

    /**
     * whether width of column automatically fits its container
     */
    public function fit(bool $fit = true)
    {
        $this->setAttribute('fit', $fit);
        return $this;
    }

    /**
     * whether Table header is visible
     */
    public function showHeader(bool $showHeader = true)
    {
        $this->setAttribute('show-header', $showHeader);
        return $this;
    }

    /**
     * whether current row is highlighted
     */
    public function highlightCurrentRow(bool $highlightCurrentRow = true)
    {
        $this->setAttribute('highlight-current-row', $highlightCurrentRow);
        return $this;
    }

    public function currentRowKey(string $currentRowKey)
    {
        $this->setAttribute('current-row-key', $currentRowKey);
        return $this;
    }

    public function rowClassName(string $rowClassName)
    {
        $this->setAttribute('row-class-name', $rowClassName);
        return $this;
    }

    public function rowStyle(string $rowStyle)
    {
        $this->setAttribute('row-style', $rowStyle);
        return $this;
    }

    public function cellClassName(string $cellClassName)
    {
        $this->setAttribute('cell-class-name', $cellClassName);
        return $this;
    }

    public function cellStyle(string $cellStyle)
    {
        $this->setAttribute('cell-style', $cellStyle);
        return $this;
    }

    public function headerRowClassName(string $headerRowClassName)
    {
        $this->setAttribute('header-row-class-name', $headerRowClassName);
        return $this;
    }

    public function headerRowStyle(string $headerRowStyle)
    {
        $this->setAttribute('header-row-style', $headerRowStyle);
        return $this;
    }

    public function headerCellClassName(string $headerCellClassName)
    {
        $this->setAttribute('header-cell-class-name', $headerCellClassName);
        return $this;
    }

    public function headerCellStyle(string $headerCellStyle)
    {
        $this->setAttribute('header-cell-style', $headerCellStyle);
        return $this;
    }

    public function rowKey(string $rowKey)
    {
        $this->setAttribute('row-key', $rowKey);
        return $this;
    }

    public function emptyText(string $emptyText)
    {
        $this->setAttribute('empty-text', $emptyText);
        return $this;
    }

    public function defaultExpandAll(bool $defaultExpandAll = true)
    {
        $this->setAttribute('default-expand-all', $defaultExpandAll);
        return $this;
    }

    public function expandRowKeys(array $expandRowKeys)
    {
        $this->setAttribute('expand-row-keys', $expandRowKeys);
        return $this;
    }

    public function defaultSort(array $defaultSort)
    {
        $this->setAttribute('default-sort', $defaultSort);
        return $this;
    }

    public function tooltipEffect(string $tooltipEffect)
    {
        $this->setAttribute('tooltip-effect', $tooltipEffect);
        return $this;
    }

    public function showSummary(bool $showSummary = true)
    {
        $this->setAttribute('show-summary', $showSummary);
        return $this;
    }

    public function sumText(string $sumText)
    {
        $this->setAttribute('sum-text', $sumText);
        return $this;
    }

    public function summaryMethod(array $summaryMethod)
    {
        $this->setAttribute('summary-method', $summaryMethod);
        return $this;
    }

    public function spanMethod(array $spanMethod)
    {
        $this->setAttribute('span-method', $spanMethod);
        return $this;
    }

    public function selectOnIndeterminate(bool $selectOnIndeterminate = true)
    {
        $this->setAttribute('select-on-indeterminate', $selectOnIndeterminate);
        return $this;
    }

    public function indent(int $indent)
    {
        $this->setAttribute('indent', $indent);
        return $this;
    }

    public function lazy(bool $lazy = true)
    {
        $this->setAttribute('lazy', $lazy);
        return $this;
    }

    public function load(array $load)
    {
        $this->setAttribute('load', $load);
        return $this;
    }

    public function treeProps(array $treeProps)
    {
        $this->setAttribute('tree-props', $treeProps);
        return $this;
    }

    public function tableLayout(string $tableLayout)
    {
        $this->setAttribute('table-layout', $tableLayout);
        return $this;
    }

    public function scrollbarAlwaysOn(bool $scrollbarAlwaysOn = true)
    {
        $this->setAttribute('scrollbar-always-on', $scrollbarAlwaysOn);
        return $this;
    }
}
