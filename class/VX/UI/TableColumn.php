<?php

namespace VX\UI;

use P\Element;
use VX\TranslatorAwareInterface;
use VX\TranslatorAwareTrait;


class TableColumn implements TranslatorAwareInterface
{
    use TranslatorAwareTrait;

    const SEARCH_TYPE_TEXT = "text";
    const SEARCH_TYPE_DATE = "date";
    const SEARCH_TYPE_SELECT = "select";

    public string $label;
    public string $prop;
    public bool $searchable;

    public function template(callable $callback, string $scope = "scope")
    {
        $template = new Template();
        $template->setAttribute("v-slot", $scope);
        $callback($template);
        $this->append($template);

        return $this;
    }

    public function setLabel(string $label)
    {
        $this->label = $label;
    }

    public function setProp(string $prop)
    {
        $this->prop = $prop;
    }

    /**
     * sortable and searchable
     */
    public function ss()
    {
        $this->sortable();
        $this->searchable();
        return $this;
    }

    public function sortable()
    {
        $this->sortable = true;
        return $this;
    }

    function minWidth(string $width)
    {
        $this->setMinWidth($width);
        return $this;
    }

    public function width(string $width)
    {
        $this->setWidth($width);
        return $this;
    }

    public function filterable(iterable $value)
    {
        $this->setFilters($value);
        $prop = $this->getAttribute("prop");
        $this->setAttribute("column-key", $prop);
        return $this;
    }

    public function overflow()
    {
        $this->setAttribute(":show-overflow-tooltip", "true");
        return $this;
    }

    public function searchable(string $type = TableColumn::SEARCH_TYPE_TEXT, callable $callback = null)
    {
        $this->searchable = true;

        return;

        $node = $this->closest("vx-table");
        if ($node instanceof Table) {
            $node->setAttribute("searchable", true);


            switch ($type) {
                case self::SEARCH_TYPE_SELECT:
                    $select = $node->search->addSelect($this->getAttribute("label"), $this->getAttribute("prop"));
                    $select->setClearable(true);

                    if ($callback) {
                        $callback($select);
                    }
                    break;

                case self::SEARCH_TYPE_TEXT:
                    $node->search->addInput($this->getAttribute("label"), $this->getAttribute("prop"));
                    break;

                case self::SEARCH_TYPE_DATE:
                    $node->search->addDate($this->getAttribute("label"), $this->getAttribute("prop"));
                    break;
            }
        }

        return $this;
    }

    public function fixed()
    {
        $this->setFixed(true);
        return $this;
    }

    public function nowrap()
    {
        //$this->setAttribute(':cell-style', json_encode(["white-space" => "nowrap"]));

        return $this;
    }

    function addLink(string $href, string $content)
    {
        $link = new Element("router-link");
        $this->template(function (Template $template) use ($href, $content, $link) {

            $link->setAttribute(":to", "scope.row." . $href);
            $link->setAttribute("v-text", "scope.row." . $content);
            $template->append($link);
        });
        return $link;
    }
}
