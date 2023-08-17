<?php

namespace FormKit\Quasar;

use FormKit\ComponentBaseNode;

class QTable extends ComponentBaseNode
{

    // Behavior
    function fullscreen(bool $fullscreen = true)
    {
        $this->attributes["fullscreen"] = $fullscreen;
        return $this;
    }

    function grid(bool $grid = true)
    {
        $this->attributes["grid"] = $grid;
        return $this;
    }

    function gridHeader(bool $gridHeader = true)
    {
        $this->attributes["grid-header"] = $gridHeader;
        return $this;
    }

    // Content
    function title(string $title)
    {
        $this->attributes["title"] = $title;
        return $this;
    }

    function hideHeader(bool $hideHeader = true)
    {
        $this->attributes["hide-header"] = $hideHeader;
        return $this;
    }

    function hideNoData(bool $hideNoData = true)
    {
        $this->attributes["hide-no-data"] = $hideNoData;
        return $this;
    }

    function hidePagination(bool $hidePagination = true)
    {
        $this->attributes["hide-pagination"] = $hidePagination;
        return $this;
    }

    //horizontal|vertical|cell|none
    function sperator(string $sperator)
    {
        $this->attributes["sperator"] = $sperator;
        return $this;
    }

    function wrapCells(bool $wrapCells = true)
    {
        $this->attributes["wrap-cells"] = $wrapCells;
        return $this;
    }

    function noResultsLabel(string $noResultsLabel)
    {
        $this->attributes["no-results-label"] = $noResultsLabel;
        return $this;
    }

    //General
    function rows(array $rows)
    {
        $this->attributes["rows"] = $rows;
        return $this;
    }

    function rowKey(string $rowKey)
    {
        $this->attributes["row-key"] = $rowKey;
        return $this;
    }


    // Style
    function color(string $color)
    {
        $this->attributes["color"] = $color;
        return $this;
    }

    function dense(bool $dense = true)
    {
        $this->attributes["dense"] = $dense;
        return $this;
    }

    function dark(bool $dark = true)
    {
        $this->attributes["dark"] = $dark;
        return $this;
    }

    function flat(bool $flat = true)
    {
        $this->attributes["flat"] = $flat;
        return $this;
    }

    function bordered(bool $bordered = true)
    {
        $this->attributes["bordered"] = $bordered;
        return $this;
    }

    function square(bool $square = true)
    {
        $this->attributes["square"] = $square;
        return $this;
    }


    //-----



    function columns(array $columns)
    {
        $this->attributes["columns"] = $columns;
        return $this;
    }
}
