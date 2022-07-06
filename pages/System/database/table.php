<div id="div1">
    {{table|raw}}
</div>

<?php
/**
 * Created by: Raymond Chong
 * Date: 2021-08-16 
 */

use P\HTMLTemplateElement;
use R\DB\Table as DBTable;
use VX\UI\EL\Button;
use VX\UI\EL\Table;

return new class
{
    function get(VX $vx)
    {
        $t = collect($vx->getDB()->getTables())->map(function (DBTable $t) {
            return [
                "name" => $t->name,
                "columns" => $t->columns()
            ];
        });

        $table = $vx->ui->createT($t);
        $table->setSize("mini");

        $column = $table->addColumn();
        $column->setType("expand");
        $column->addTemplate(function (HTMLTemplateElement  $template) {

            $btn = new Button();
            $btn->setSize($btn::SIZE_MINI);
            $btn->setAttribute("v-on:click", "onClick(scope.row.name)");
            $btn->textContent = "add";

            $template->append($btn);

            $t = new Table;
            $t->setSize($t::SIZE_MINI);
            $t->setAttribute(":data", "scope.row.columns");
            $col = $t->addColumn();
            $col->addTemplate(function (HTMLTemplateElement $template) {
                $btn = new Button();
                $btn->setSize($btn::SIZE_MINI);
                $btn->setAttribute("v-on:click", "onRemove(scope.row.name,scope2.row.Field)");
                $btn->textContent = "remove";
                $template->append($btn);
            }, "scope2");

            $t->addColumn("Field", "Field");
            $t->addColumn("Type", "Type");
            $t->addColumn("Default", "Default");
            $t->addColumn("Extra", "Extra");
            $t->addColumn("Key", "Key");

            $template->append($t);
        });


        $col = $table->addColumn("Name", "name");
        $col->setSortable(true);

        $this->table = $table;


        //        outP($vx->getDB()->getMetadata()->getTriggers());
        //die();
    }
};
