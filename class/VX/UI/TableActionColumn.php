<?php

namespace VX\UI;

use P\HTMLElement;

class TableActionColumn extends TableColumn
{
    public function addView()
    {
        $this->append($node = new HTMLElement("router-link"));
        $node->style->color = "inherit";
        $node->classList->add("mx-25", "px-25");
        $node->setAttribute("v-if", "props.row.__view__");
        $node->setAttribute(":to", "props.row.__view__");

        $node->append($tooltip = new HTMLElement("el-tooltip"));
        $tooltip->setAttribute("effect", "dark");
        $tooltip->setAttribute("content", $this->translator->trans("View"));
        $tooltip->setAttribute("placement", "top-start");


        $tooltip->append($icon = new Icon());
        $icon->setName("eye");
        $icon->setWidth(16);

        return $node;
    }

    public function addEdit()
    {
        $this->append($node = new HTMLElement("router-link"));
        $node->style->color = "inherit";
        $node->classList->add("mx-25", "px-25");
        $node->setAttribute("v-if", "props.row.__update__");
        $node->setAttribute(":to", "props.row.__update__");

        $node->append($tooltip = new HTMLElement("el-tooltip"));
        $tooltip->setAttribute("effect", "dark");
        $tooltip->setAttribute("content", $this->translator->trans("Edit"));
        $tooltip->setAttribute("placement", "top-start");


        $tooltip->append($icon = new Icon());
        $icon->setName("edit-3");
        $icon->setWidth(16);

        return $node;
    }

    public function addDelete()
    {
        $this->append($node = new HTMLElement("a"));

        $node->classList->add("mx-25", "px-25");
        $node->setAttribute("v-if", "props.row.__delete__");
        $node->setAttribute("v-on:click", "table.delete(props.row.__delete__)");

        $node->append($tooltip = new HTMLElement("el-tooltip"));
        $tooltip->setAttribute("effect", "dark");
        $tooltip->setAttribute("content", $this->translator->trans("Delete"));
        $tooltip->setAttribute("placement", "top-start");


        $tooltip->append($icon = new Icon());
        $icon->setName("trash");
        $icon->setWidth(16);

        return $node;
    }
}
