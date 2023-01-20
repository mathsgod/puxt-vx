<?php

namespace FormKit;

use Symfony\Contracts\Translation\TranslatorInterface;

class ElTable extends ComponentNode
{
    public function __construct(array $property = [], ?TranslatorInterface $translator = null)
    {
        parent::__construct('ElTable', $property, $translator);
    }

    public function addTableColumn()
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
        $this->props['data'] = $data;
        return $this;
    }

    /**
     * Table's height. By default it has an auto height. If its value is a number, the height is measured in pixels; if its value is a string, the value will be assigned to element's style.height, the height is affected by external styles
     */
    public function height(string|int $height)
    {
        $this->setProperty('height', $height);
        return $this;
    }

    /**
     * Table's max-height. The legal value is a number or the height in px.
     */
    public function maxHeight(string|int $maxHeight)
    {
        $this->setProperty('max-height', $maxHeight);
        return $this;
    }

    /**
     * whether Table is striped
     */
    public function stripe(bool $stripe = true)
    {
        $this->setProperty('stripe', $stripe);
        return $this;
    }

    /**
     * whether Table has vertical border
     */
    public function border(bool $border = true)
    {
        $this->setProperty('border', $border);
        return $this;
    }

    /**
     * size of Table
     */
    public function size(string $size)
    {
        $this->setProperty('size', $size);
        return $this;
    }

    /**
     * whether width of column automatically fits its container
     */
    public function fit(bool $fit = true)
    {
        $this->setProperty('fit', $fit);
        return $this;
    }

    /**
     * whether Table header is visible
     */
    public function showHeader(bool $showHeader = true)
    {
        $this->setProperty('show-header', $showHeader);
        return $this;
    }

    /**
     * whether current row is highlighted
     */
    public function highlightCurrentRow(bool $highlightCurrentRow = true)
    {
        $this->setProperty('highlight-current-row', $highlightCurrentRow);
        return $this;
    }

    public function currentRowKey(string $currentRowKey)
    {
        $this->setProperty('current-row-key', $currentRowKey);
        return $this;
    }

    public function rowClassName(string $rowClassName)
    {
        $this->setProperty('row-class-name', $rowClassName);
        return $this;
    }

    public function rowStyle(string $rowStyle)
    {
        $this->setProperty('row-style', $rowStyle);
        return $this;
    }

    public function cellClassName(string $cellClassName)
    {
        $this->setProperty('cell-class-name', $cellClassName);
        return $this;
    }

    public function cellStyle(string $cellStyle)
    {
        $this->setProperty('cell-style', $cellStyle);
        return $this;
    }

    public function headerRowClassName(string $headerRowClassName)
    {
        $this->setProperty('header-row-class-name', $headerRowClassName);
        return $this;
    }

    public function headerRowStyle(string $headerRowStyle)
    {
        $this->setProperty('header-row-style', $headerRowStyle);
        return $this;
    }

    public function headerCellClassName(string $headerCellClassName)
    {
        $this->setProperty('header-cell-class-name', $headerCellClassName);
        return $this;
    }

    public function headerCellStyle(string $headerCellStyle)
    {
        $this->setProperty('header-cell-style', $headerCellStyle);
        return $this;
    }

    public function rowKey(string $rowKey)
    {
        $this->setProperty('row-key', $rowKey);
        return $this;
    }

    public function emptyText(string $emptyText)
    {
        $this->setProperty('empty-text', $emptyText);
        return $this;
    }

    public function defaultExpandAll(bool $defaultExpandAll = true)
    {
        $this->setProperty('default-expand-all', $defaultExpandAll);
        return $this;
    }

    public function expandRowKeys(array $expandRowKeys)
    {
        $this->setProperty('expand-row-keys', $expandRowKeys);
        return $this;
    }

    public function defaultSort(array $defaultSort)
    {
        $this->setProperty('default-sort', $defaultSort);
        return $this;
    }

    public function tooltipEffect(string $tooltipEffect)
    {
        $this->setProperty('tooltip-effect', $tooltipEffect);
        return $this;
    }

    public function showSummary(bool $showSummary = true)
    {
        $this->setProperty('show-summary', $showSummary);
        return $this;
    }

    public function sumText(string $sumText)
    {
        $this->setProperty('sum-text', $sumText);
        return $this;
    }

    public function summaryMethod(array $summaryMethod)
    {
        $this->setProperty('summary-method', $summaryMethod);
        return $this;
    }

    public function spanMethod(array $spanMethod)
    {
        $this->setProperty('span-method', $spanMethod);
        return $this;
    }

    public function selectOnIndeterminate(bool $selectOnIndeterminate = true)
    {
        $this->setProperty('select-on-indeterminate', $selectOnIndeterminate);
        return $this;
    }

    public function indent(int $indent)
    {
        $this->setProperty('indent', $indent);
        return $this;
    }

    public function lazy(bool $lazy = true)
    {
        $this->setProperty('lazy', $lazy);
        return $this;
    }

    public function load(array $load)
    {
        $this->setProperty('load', $load);
        return $this;
    }

    public function treeProps(array $treeProps)
    {
        $this->setProperty('tree-props', $treeProps);
        return $this;
    }

    public function tableLayout(string $tableLayout)
    {
        $this->setProperty('table-layout', $tableLayout);
        return $this;
    }

    public function scrollbarAlwaysOn(bool $scrollbarAlwaysOn = true)
    {
        $this->setProperty('scrollbar-always-on', $scrollbarAlwaysOn);
        return $this;
    }
}
