<?php

/**
 * @author Raymond Chong
 * @date 2023-01-30 
 */

use VX\Config;

return new class
{
    function get(VX $vx)
    {

        $schema = $vx->createSchema();
        $form = $schema->addForm();
        $form->value(Config::FromGlobal());
        $form->action("/Config");
        $form->addInput("Name", "name")->validation("required");
        $form->addInput("Value", "value")->validation("required");

        return $schema;
    }
};
