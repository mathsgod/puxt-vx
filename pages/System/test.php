<?php

/**
 * @author Raymond Chong
 * @date 2023-01-30 
 */

use Laminas\Diactoros\Response\EmptyResponse;
use Laminas\Diactoros\Response\TextResponse;
use VX\User;

return new class
{
    function post(VX $vx)
    {

        return new TextResponse("Success response");

        return new TextResponse("Error response", 400);

        outp($vx->_post);
        outp($vx->_files);
        die();
        return new EmptyResponse();
        die();
        return new EmptyResponse(201);
    }

    function get(VX $vx)
    {
        throw new \Exception("test by exception");
        die();
        $schema = $vx->createSchema();

        $schema->addElText()->children("Hello World")->type("primary")->size("large")->truncated(true)->tag("h1");

        $ph = $schema->addElPageHeader();





        $ph->title("Title");

        $t = $schema->createElement("template");
        /*    $t->attr("#content", true);
        $t->addChildren("Content"); */

        /*     $t = $schema->createComponent("template");
        $t->setProp("v-slot:content", true);
        $t->addChildren("Content");
 */

        $ph->addChildren($t);

        $b = $schema->addElBreadcrumb();
        $b->addBreadcrumbItem()->to("/User")->children("test");
        $b->addBreadcrumbItem()->to("/User/1/view")->children("test2");
        $b->addBreadcrumbItem()->to("/User/1/view")->children("test3");



        $schema->addElAvatar();

        $schema->addElBacktop();

        $container = $schema->addElContainer();
        $container->addAside()->children("Aside");

        $c2 = $container->addContainer();

        $c2->addHeader()->children("Header");


        $c2->addMain()->children("Main");
        $c2->addFooter()->children("Footer");

        $schema->addElTag()->children("test");

        $tabs = $schema->addElTabs()->type("border-card");
        $pane1 = $tabs->addPane("Pane1");
        $pane1->addChildren("hello");

        $pane2 = $tabs->addPane("Pane2");
        $pane2->addChildren("hello2");



        $card = $schema->addFKForm();
        $card->addText("Input1", "input1")->validation("required")->prefixIcon("email")->suffixIcon("search")->placeholder("Input1");
        $card->addFKSelect("Select", "select")->options(["a" => "A", "b" => "B"])->placeholder("Select")->selectIcon("search");
        $card->addFKRadio("Radio", "radio")->options(["a" => "A", "b" => "B"]);
        $card->addFKEmail("Email", "email")->placeholder("Email");
        $card->addFKFile("File", "file");
        $card->addFKCheckbox("Checkbox", "checkbox")->options(["a" => "A", "b" => "B"]);
        $card->addFKDate("Date", "date");
        $card->addFKDatetimeLocal("Datetime Local", "datetime_local");


        return $schema;

        $table = $schema->addElTable();
        $table->data(User::Query()->limit(10)->toArray());
        $table->addColumn()->label("Name")->prop("username");

        $col = $table->addColumn()->label("Top1")->sortable();
        $col = $col->addColumn()->label("Grouped");
        $col->addColumn()->label("Email")->prop("email")->sortable();
        $col->addColumn()->label("First name")->prop("first_name")->sortable();



        return $schema;


        $form = $schema->addForm();
        $form->addInput("Name", "name")->validation("required");
        $form->addCheckbox("Checkbox", "cb1");
        $form->addInputNumber("Number", "number")->validation("required");
        $form->addDatePicker("Date", "date");
        $form->addDateRangePicker("Date Range", "date_range");
        $form->addTimePicker("Time", "time");
        $form->addRate("Rate", "rate");
        $form->addSlider("Slider", "slider");
        $form->addSwitch("Switch", "switch");
        $form->addColorPicker("Color", "color");
        $form->addTransfer("Transfer", "transfer");
        $form->addRadioGroup("Radio", "radio")->options(["a" => "A", "b" => "B"]);
        $form->addCheckboxGroup("Checkbox", "checkbox")->options(["a" => "A", "b" => "B"]);
        $form->addTree("Tree", "tree")->nodeKey("label")->data([
            ["label" => "test1", "children" => [["label" => "test1-1"]]],
            ["label" => "test2", "children" => [["label" => "test2-1"]]],
        ]);

        //$schema->addCodeInput("Code", "code")->language("javascript")->height("300px");
        return $schema;

        $schema->addChildren($schema->createElement("a"));

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


        $div = $schema->addElement("div")->children("div content");
        $div->if('$get(cb1).value');


        return $schema;
    }
};
