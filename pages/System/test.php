<?php

/**
 * Created by: Raymond Chong
 * Date: 2022-09-14 
 */

use Laminas\Diactoros\Response\EmptyResponse;
use VX\User;

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
        $form->action("/System/test");
        $form->value(["username" => "test"]);
        $form->addInput("username")->label("Username")->validation("required");


        return ["schema" => $schema];

        /*        $schema->addComponent("FormKit", [
            "type" => "VxForm",
        ]);

         */



        /*   $table = $schema->addComponent("VxTable", [
            "query" => "MailLog?fields[]=body&sort[]=maillog_id:desc"
        ]);

        $col = $schema->createComponent("VxColumn", [
            "label" => "ID",
            "prop" => "maillog_id",
            "sortable" => true,
            "width" => 100,
        ]);

        $table->addChildren($col);


        return ["schema" => $schema]; */



        $table = $schema->addTable()->data(User::Query()->toArray())->size("small");
        //$table->height(100);
        $table->addColumn()->label("ID")->prop("username");
        $table->addColumn()->label("First name")->prop("first_name")->sortable();





        $schema->addTag()->type("primary")->addChildren("hello");

        $schema->addCheckbox("show_card")->label("Show Card");

        $card = $schema->addCard()->header("Card 1")->shadow("never");

        $card->if('$show_card');

        $card->addChildren("test");

        $timeline = $card->addTimeline();

        $timeline->addTimelineItem()->timestamp("2022-01-20")->addChildren("test");
        $timeline->addTimelineItem()->timestamp("2022-01-21")->addChildren("test2");
        $timeline->addTimelineItem()->timestamp("2022-01-22")->addChildren("test2");
        $timeline->addTimelineItem()->timestamp("2022-01-23")->addChildren("test3");
        $item = $timeline->addTimelineItem()->timestamp("2022-01-23");
        $card = $item->addCard()->header("Card 2")->shadow("never")->addChildren("card body");



        $h1 = $schema->addElement("h1");
        $h1->addChildren("hello1");
        $h1->addChildren("hello2");

        $div = $schema->addElement("div");
        $div->addChildren("testing a testing");


        $schema->addDivider("Divider 1");

        $schema->addInput("input_1")->label("Input 1")->clearable()->placeholder("Input 1")->help("Input 1 Help");

        $schema->addPassword("password_1")->label("Password 1")->clearable()->placeholder("Password 1")->help("Password 1 Help");

        $schema->addInputNumber("input_number_1")->label("Input Number 1");
        $schema->addInputNumber("input_number_2")->label("Input Number 2")->min(10)->max(20)->step(2);


        $schema->addSelect("select_1")->label("Select 1")->options(["option 1", "option 2", "option 3"]);
        $schema->addSelect("select_2")->label("Select 2")->options(["option 1", "option 2", "option 3"])->multiple();

        $schema->addSwitch("switch_1")->label("Switch 1")->help("Switch 1 Help");

        $schema->addCheckbox("checkbox_1")->label("Checkbox 1")->help("Checkbox 1 Help");

        $schema->addRadioGroup("radio_group_1")->label("Radio Group 1")->options(["option 1", "option 2", "option 3"]);


        $schema->addDatePicker("date_picker_1")->label("Date Picker 1")->help("Date Picker 1 Help");
        $schema->addColorPicker("color_picker_1")->label("Color Picker 1")->help("Color Picker 1 Help");

        $schema->addDateRangePicker("date_range_picker_1")->label("Date Range Picker 1")->help("Date Range Picker 1 Help");

        $schema->addRate("rate_1")->label("Rate 1")->help("Rate 1 Help");

        $schema->addSlider("slider_1")->label("Slider 1")->help("Slider 1 Help");

        $schema->addTextarea("textarea_1")->label("Textarea 1")->help("Textarea 1 Help");

        $schema->addTimeSelect("time_select_1")->label("Time Select 1")->help("Time Select 1 Help");

        $schema->addTimePicker("time_picker_1")->label("Time Picker 1")->help("Time Picker 1 Help");

        $schema->addTransfer("transfer_1")->label("Transfer 1")->help("Transfer 1 Help");

        $schema->addUpload("upload_1")->label("Upload 1")->help("Upload 1 Help");

        $card = $schema->addComponent("ElCard");
        $card->addInput("input_1")->label("Input 1")->clearable()->placeholder("Input 1")->help("Input 1 Help");
        $card->addDatePicker("date_picker_1")->label("Date Picker 1")->help("Date Picker 1 Help");

        /* $s = new Schema();
        $s->addInput("input_1")->label("Input 1")->clearable()->placeholder("Input 1")->help("Input 1 Help");
        $card->children($s);
 */


        return ["schema" => $schema];
    }
};
