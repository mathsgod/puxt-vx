<?php

/**
 * @author Raymond Chong
 * @date 2023-01-30 
 */

use Laminas\Diactoros\Response\EmptyResponse;

return new class
{
    function post()
    {
        return new EmptyResponse(200);
    }

    function get(VX $vx)
    {
        $schema = $vx->createSchema();
        $form = $schema->addForm();
        $form->action("/System/abc");


        $form->addInput("Name", "name")->validation("required");
        $form->addInput("Email", "email")->validation("required|email");

        return $schema;


        $schema->addElement("h1")->addChildren("Hello World");

        $schema->addCheckbox("Checkbox", "cb1")->id("cb1");


        $div = $schema->addElement("div")->addChildren("div content");
        $div->if('$get(cb1).value');


        return $schema;
    }
};
