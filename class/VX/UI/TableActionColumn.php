<?php

namespace VX\UI;

use P\HTMLElement;

class TableActionColumn extends TableColumn
{
    public function addView()
    {
        $this->appendChild($node = new HTMLElement("router-link"));
        $node->style->color = "inherit";
        $node->classList->add("mx-1 px-1");
        $node->setAttribute("v-if", "props.row.__view__");
        $node->setAttribute(":to", "props.row.__view__");

        $node->append($tooltip = new HTMLElement("el-tooltip"));
        $tooltip->setAttribute("effect", "dark");
        $tooltip->setAttribute("content", $this->translator->trans("View"));
        $tooltip->setAttribute("placement", "top");


        $tooltip->append($icon = new Q\Icon());
        $icon->setName("far fa-eye");
        $icon->setSize("xs");
        //$icon->setWidth(16);

        return $node;
    }

    public function addEdit()
    {
        $this->append($node = new HTMLElement("router-link"));
        $node->style->color = "inherit";
        $node->classList->add("mx-1 px-1");
        $node->setAttribute("v-if", "props.row.__update__");
        $node->setAttribute(":to", "props.row.__update__");

        $node->append($tooltip = new HTMLElement("el-tooltip"));
        $tooltip->setAttribute("effect", "dark");
        $tooltip->setAttribute("content", $this->translator->trans("Edit"));
        $tooltip->setAttribute("placement", "top");


        $tooltip->append($icon = new Q\Icon());
        $icon->setName("far fa-edit");
        $icon->setSize("xs");

        return $node;
    }

    public function addDelete()
    {
        $this->append($node = new HTMLElement("q-btn"));
        $node->setAttribute("flat", true);

        $node->classList->add("mx-1 px-1");
        $node->setAttribute("v-if", "props.row.__delete__");
        $node->setAttribute("v-on:click", "table.delete(props.row.__delete__)");

        $node->append($tooltip = new HTMLElement("el-tooltip"));
        $tooltip->setAttribute("effect", "dark");
        $tooltip->setAttribute("content", $this->translator->trans("Delete"));
        $tooltip->setAttribute("placement", "top");


        $tooltip->append($icon = new Q\Icon());
        $icon->setName("fa-regular fa-trash-can");
        //$icon->setWidth(16);
        $icon->setSize("xs");

        return $node;
    }
}
