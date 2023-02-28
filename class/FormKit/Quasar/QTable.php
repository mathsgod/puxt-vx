<?php

namespace FormKit\Quasar;

use FormKit\ComponentBaseNode;

class QTable extends ComponentBaseNode
{
    public function __construct(array $property = [])
    {
        parent::__construct("QTable", $property);
    }

    // Behavior
    function fullscreen(bool $fullscreen = true)
    {
        $this->props["fullscreen"] = $fullscreen;
        return $this;
    }

    function grid(bool $grid = true)
    {
        $this->props["grid"] = $grid;
        return $this;
    }

    function gridHeader(bool $gridHeader = true)
    {
        $this->props["grid-header"] = $gridHeader;
        return $this;
    }

    // Content
    function title(string $title)
    {
        $this->props["title"] = $title;
        return $this;
    }

    function hideHeader(bool $hideHeader = true)
    {
        $this->props["hide-header"] = $hideHeader;
        return $this;
    }

    function hideNoData(bool $hideNoData = true)
    {
        $this->props["hide-no-data"] = $hideNoData;
        return $this;
    }

    function hidePagination(bool $hidePagination = true)
    {
        $this->props["hide-pagination"] = $hidePagination;
        return $this;
    }

    //horizontal|vertical|cell|none
    function sperator(string $sperator)
    {
        $this->props["sperator"] = $sperator;
        return $this;
    }

    function wrapCells(bool $wrapCells = true)
    {
        $this->props["wrap-cells"] = $wrapCells;
        return $this;
    }

    function noResultsLabel(string $noResultsLabel)
    {
        $this->props["no-results-label"] = $noResultsLabel;
        return $this;
    }

    //General
    function rows(array $rows)
    {
        $this->props["rows"] = $rows;
        return $this;
    }
    
    function rowKey(string $rowKey)
    {
        $this->props["row-key"] = $rowKey;
        return $this;
    }


    // Style
    function color(string $color)
    {
        $this->props["color"] = $color;
        return $this;
    }

    function dense(bool $dense = true)
    {
        $this->props["dense"] = $dense;
        return $this;
    }

    function dark(bool $dark = true)
    {
        $this->props["dark"] = $dark;
        return $this;
    }

    function flat(bool $flat = true)
    {
        $this->props["flat"] = $flat;
        return $this;
    }

    function bordered(bool $bordered = true)
    {
        $this->props["bordered"] = $bordered;
        return $this;
    }

    function square(bool $square = true)
    {
        $this->props["square"] = $square;
        return $this;
    }


    //-----



    function columns(array $columns)
    {
        $this->props["columns"] = $columns;
        return $this;
    }
}
