<?php

namespace FormKit\Quasar;

use FormKit\ComponentBaseNode;

class QTable extends ComponentBaseNode
{

    // Behavior
    function fullscreen(bool $fullscreen = true)
    {
        $this->setAttribute("fullscreen", $fullscreen);
        return $this;
    }

    function grid(bool $grid = true)
    {
        $this->setAttribute("grid", $grid);
        return $this;
    }

    function gridHeader(bool $gridHeader = true)
    {
        $this->setAttribute("grid-header", $gridHeader);
        return $this;
    }

    // Content
    function title(string $title)
    {
        $this->setAttribute("title", $title);
        return $this;
    }

    function hideHeader(bool $hideHeader = true)
    {
        $this->setAttribute("hide-header", $hideHeader);
        return $this;
    }

    function hideNoData(bool $hideNoData = true)
    {
        $this->setAttribute("hide-no-data", $hideNoData);
        return $this;
    }

    function hidePagination(bool $hidePagination = true)
    {
        $this->setAttribute("hide-pagination", $hidePagination);
        return $this;
    }

    //horizontal|vertical|cell|none
    function sperator(string $sperator)
    {
        $this->setAttribute("sperator", $sperator);
        return $this;
    }

    function wrapCells(bool $wrapCells = true)
    {
        $this->setAttribute("wrap-cells", $wrapCells);
        return $this;
    }

    function noResultsLabel(string $noResultsLabel)
    {
        $this->setAttribute("no-results-label", $noResultsLabel);
        return $this;
    }

    //General
    function rows(array $rows)
    {
        $this->setAttribute("rows", $rows);
        return $this;
    }

    function rowKey(string $rowKey)
    {
        $this->setAttribute("row-key", $rowKey);
        return $this;
    }


    // Style
    function color(string $color)
    {
        $this->setAttribute("color", $color);
        return $this;
    }

    function dense(bool $dense = true)
    {
        $this->setAttribute("dense", $dense);
        return $this;
    }

    function dark(bool $dark = true)
    {
        $this->setAttribute("dark", $dark);
        return $this;
    }

    function flat(bool $flat = true)
    {
        $this->setAttribute("flat", $flat);
        return $this;
    }

    function bordered(bool $bordered = true)
    {
        $this->setAttribute("bordered", $bordered);
        return $this;
    }

    function square(bool $square = true)
    {
        $this->setAttribute("square", $square);
        return $this;
    }


    //-----



    function columns(array $columns)
    {
        $this->setAttribute("columns", $columns);
        return $this;
    }
}
