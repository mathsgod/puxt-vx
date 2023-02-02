<?php

/**
 * @author Raymond Chong
 * @date 2023-01-30 
 */

use Laminas\Diactoros\Response\EmptyResponse;

return new class
{
    function post(VX $vx)
    {

        outp($vx->_post);
        outp($vx->_files);
        die();
        return new EmptyResponse();
        die();
        return new EmptyResponse(201);
    }

    function get(VX $vx)
    {
        $schema = $vx->createSchema();
        $form = $schema->addForm();
        $form->value(["name" => "test"]);
        $form->action("/System/abc");

        $form->addInput("Name", "name")->validation("required");
        $form->addInput("Email", "email");

        //$form->addFileInput("File", "file");

        $form->addFileInput("File", "file")->validation("required");

        //$form->addFormKitComponent("vxFormFileInput", ["label" => "File", "name" => "file"]);

        //$form->addUpload("Upload", "upload")->addChildren("Upload");

        //$schema->addComponent("router-link", ["to" => "/System/def"])->addChildren("Router Link");

        return $schema;


        $schema->addElement("h1")->addChildren("Hello World");

        $schema->addCheckbox("Checkbox", "cb1")->id("cb1");


        $div = $schema->addElement("div")->addChildren("div content");
        $div->if('$get(cb1).value');


        return $schema;
    }
};
