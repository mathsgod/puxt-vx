<?php

/**
 * @author Raymond Chong
 * @date 2023-01-30 
 */

use Laminas\Diactoros\Response\EmptyResponse;
use VX\User;

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

        $result = $schema->addResult()->title("test")->subTitle("test2")->icon("success");

        $template = $result->addElement("template");

        $template->attr("#extra", true);
        $template->addElement("div")->addChildren("extra information");




        $empty = $schema->addEmpty()->imageSize(100);


        $collapse = $schema->addCard()->addCollapse()->accordion()->value("t2");

        $collapse->addItem("Title1", "t1")->addChildren("test");
        $collapse->addItem("Title2", "t2")->addChildren("test2");

        return $schema;



        $badge = $schema->addBadge()->value(10)->type("primary");
        $badge->addButton("test");

        return $schema;

        $form = $schema->addElForm();

        $fi = $form->addElFormItem()->label("Test");

        $fi->addElInput(null, "name")->validation("required");
        return $schema;
        return;


        $form = $schema->addForm();
        $form->action("/System/abc");

        $form->value(["users" => User::Query()->toArray()]);



        $repeater = $form->addRepeater("Users", "users")->min(0)->help("test is help test");

        $repeater->addInput("Username", "username")->validation("required");
        $repeater->addInput("Email", "email");


        return $schema;




        $form = $schema->addForm();
        $form->action("/System/abc");

        $list = $form->addFormKitComponent("list", ["value" => [
            ["name" => "test1", "mobile" => "123"],
            ["name" => "test2", "mobile" => "456"],
            ["name" => "test3", "mobile" => "789"],

        ], "name" => "mylist"]);

        $group = $list->addGroup()->name("group1");
        $group->addInput("Name", "name")->validation("required");
        $group->addInput("Mobile", "mobile")->validation("required");





        //        $schema->addFormKitComponent("text", ["label" => "Name", "name" => "name", "validation" => "required", "value" => "test"]);
        //      $schema->addSubmit();

        /*         $group = $schema->addCard()->addGroup();
        $group->value(["name" => "testabc"]);
        $group->addInput("Name", "name")->validation("required");
 */
        //$group->addFormKitComponent("text", ["label" => "Name", "name" => "name", "validation" => "required"]);

        return $schema;



        $form = $schema->addForm();
        $form->value(["name" => "test"]);
        $form->action("/System/abc");



        $form->addInput("Name", "name")->validation("required");
        $form->addInput("Email", "email");

        //$form->addFileInput("File", "file");

        $form->addFileInput("File", "file");

        $form->addCodeInput("Code", "code")->language("javascript")->height("300px");

        //$form->addFormKitComponent("vxFormFileInput", ["label" => "File", "name" => "file"]);

        $form->addUpload("Upload", "upload")->addChildren("Upload");

        $form->addTinymce("Tinymce", "tinymce")->height("200");

        //$schema->addComponent("router-link", ["to" => "/System/def"])->addChildren("Router Link");

        return $schema;


        $schema->addElement("h1")->addChildren("Hello World");

        $schema->addCheckbox("Checkbox", "cb1")->id("cb1");


        $div = $schema->addElement("div")->addChildren("div content");
        $div->if('$get(cb1).value');


        return $schema;
    }
};
