<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class ElTable extends ComponentBaseNode
{
    public function __construct(array $props = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct("ElTable", $props, $translator);
    }

    public function addColumn()
    {
        $column = new ElTableColumn([], $this->translator);
        $this->children[] = $column;
        return $column;
    }

    /**
     * Table data
     */
    public function data($data)
    {
        $this->setProp('data', $data);
        return $this;
    }

    /**
     * Table's height. By default it has an auto height. If its value is a number, the height is measured in pixels; if its value is a string, the value will be assigned to element's style.height, the height is affected by external styles
     */
    public function height(string|int $height)
    {
        $this->setProp('height', $height);
        return $this;
    }

    /**
     * Table's max-height. The legal value is a number or the height in px.
     */
    public function maxHeight(string|int $maxHeight)
    {
        $this->setProp('max-height', $maxHeight);
        return $this;
    }

    /**
     * whether Table is striped
     */
    public function stripe(bool $stripe = true)
    {
        $this->setProp('stripe', $stripe);
        return $this;
    }

    /**
     * whether Table has vertical border
     */
    public function border(bool $border = true)
    {
        $this->setProp('border', $border);
        return $this;
    }

    /**
     * size of Table
     */
    public function size(string $size)
    {
        $this->setProp('size', $size);
        return $this;
    }

    /**
     * whether width of column automatically fits its container
     */
    public function fit(bool $fit = true)
    {
        $this->setProp('fit', $fit);
        return $this;
    }

    /**
     * whether Table header is visible
     */
    public function showHeader(bool $showHeader = true)
    {
        $this->setProp('show-header', $showHeader);
        return $this;
    }

    /**
     * whether current row is highlighted
     */
    public function highlightCurrentRow(bool $highlightCurrentRow = true)
    {
        $this->setProp('highlight-current-row', $highlightCurrentRow);
        return $this;
    }

    public function currentRowKey(string $currentRowKey)
    {
        $this->setProp('current-row-key', $currentRowKey);
        return $this;
    }

    public function rowClassName(string $rowClassName)
    {
        $this->setProp('row-class-name', $rowClassName);
        return $this;
    }

    public function rowStyle(string $rowStyle)
    {
        $this->setProp('row-style', $rowStyle);
        return $this;
    }

    public function cellClassName(string $cellClassName)
    {
        $this->setProp('cell-class-name', $cellClassName);
        return $this;
    }

    public function cellStyle(string $cellStyle)
    {
        $this->setProp('cell-style', $cellStyle);
        return $this;
    }

    public function headerRowClassName(string $headerRowClassName)
    {
        $this->setProp('header-row-class-name', $headerRowClassName);
        return $this;
    }

    public function headerRowStyle(string $headerRowStyle)
    {
        $this->setProp('header-row-style', $headerRowStyle);
        return $this;
    }

    public function headerCellClassName(string $headerCellClassName)
    {
        $this->setProp('header-cell-class-name', $headerCellClassName);
        return $this;
    }

    public function headerCellStyle(string $headerCellStyle)
    {
        $this->setProp('header-cell-style', $headerCellStyle);
        return $this;
    }

    public function rowKey(string $rowKey)
    {
        $this->setProp('row-key', $rowKey);
        return $this;
    }

    public function emptyText(string $emptyText)
    {
        $this->setProp('empty-text', $emptyText);
        return $this;
    }

    public function defaultExpandAll(bool $defaultExpandAll = true)
    {
        $this->setProp('default-expand-all', $defaultExpandAll);
        return $this;
    }

    public function expandRowKeys(array $expandRowKeys)
    {
        $this->setProp('expand-row-keys', $expandRowKeys);
        return $this;
    }

    public function defaultSort(array $defaultSort)
    {
        $this->setProp('default-sort', $defaultSort);
        return $this;
    }

    public function tooltipEffect(string $tooltipEffect)
    {
        $this->setProp('tooltip-effect', $tooltipEffect);
        return $this;
    }

    public function showSummary(bool $showSummary = true)
    {
        $this->setProp('show-summary', $showSummary);
        return $this;
    }

    public function sumText(string $sumText)
    {
        $this->setProp('sum-text', $sumText);
        return $this;
    }

    public function summaryMethod(array $summaryMethod)
    {
        $this->setProp('summary-method', $summaryMethod);
        return $this;
    }

    public function spanMethod(array $spanMethod)
    {
        $this->setProp('span-method', $spanMethod);
        return $this;
    }

    public function selectOnIndeterminate(bool $selectOnIndeterminate = true)
    {
        $this->setProp('select-on-indeterminate', $selectOnIndeterminate);
        return $this;
    }

    public function indent(int $indent)
    {
        $this->setProp('indent', $indent);
        return $this;
    }

    public function lazy(bool $lazy = true)
    {
        $this->setProp('lazy', $lazy);
        return $this;
    }

    public function load(array $load)
    {
        $this->setProp('load', $load);
        return $this;
    }

    public function treeProps(array $treeProps)
    {
        $this->setProp('tree-props', $treeProps);
        return $this;
    }

    public function tableLayout(string $tableLayout)
    {
        $this->setProp('table-layout', $tableLayout);
        return $this;
    }

    public function scrollbarAlwaysOn(bool $scrollbarAlwaysOn = true)
    {
        $this->setProp('scrollbar-always-on', $scrollbarAlwaysOn);
        return $this;
    }
}
