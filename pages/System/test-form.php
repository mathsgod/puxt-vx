{{form|raw}}
<?php

/**
 * Created by: Raymond Chong
 * Date: 2021-07-07 
 */

use Laminas\Diactoros\ServerRequestFactory;
use VX\UI\EL\OptionGroup;
use VX\UserGroup;

return new class
{
    function post(VX $vx)
    {


        outp($vx->_files);
        outp($vx->_post);
        die();

        outp($vx->_post);
        outp($_FILES);
        outP($vx->req->getParsedBody());
        outp($vx->req->getUploadedFiles());
        die();
    }

    function get(VX $vx)
    {
        $form = $vx->ui->createForm([
            "file" => 'a.jpg', "file2" => "hello", "transfer1" => [1, 2],
            "upload1" => [],
            "upload2" => []
        ]);
        $form->setAction();


        $form->add("Select with group")->select("s2")->addOptionGroup(UserGroup::Query()->map(function ($ug) {
            return [
                "object" => $ug,
                "label" => $ug->name,
            ];
        }), function (OptionGroup $og, $group) {
            $ug = $group["object"];
            foreach ($ug->User() as $user) {
                $og->addOption($user->user_id, $user->__toString());
            }
        });

        $form->add("Create new items select")->select("s1", ["a", "b", "c"])->setAllowCreate(true);

        $form->add("Upload")->upload("upload1");
        $upload = $form->add("mutiple Upload")->upload("upload2");
        $upload->setMultiple(true);

        $form->add("Switch")->switch("switch1");


        $form->add("input nubmer")->inputNumber("input_number_1");


        $form->add("Transfer")->transfer("transfer1")->setData([
            [
                "key" => 1,
                "label" => "A"
            ], [
                "key" => 2,
                "label" => "B"
            ], [
                "key" => 3,
                "label" => "C"
            ]
        ])->filterable()->setTitles(["a", "b"]);

        $rate = $form->add("Rate")->rate("rate1");
        $rate->setShowText(true);
        $rate->setShowScore(true);

        $form->add("Color Picker")->colorPicker('color1');

        $form->add("Date")->datePicker("date1");
        $form->add("Date time")->dateTimePicker("date2");

        $form->add("Time Picker")->timePicker("time1")
            ->setArrowControl()
            ->setPlaceholder("holder");

        $form->add("Time Picker Range")->timePicker("time2")->setIsRange();



        $form->add("Time Select")->timeSelect("time3")->setStart("10:00");
        $form->add("File")->filemanager("file");
        $tinymce = $form->add("tinymce")->tinymce("file2");
        $tinymce->setAttribute("api-key", "bfqasodzk1neqa8lmfym5h5x913j7u199hy7rm90a7p30ozn");
        $tinymce->setAttribute(":height", 300);
        $tinymce->setAttribute("base-url", "http://192.168.88.108:8001/vx/uploads/");

        //$form->add("text1")-
        $this->form = $form;
    }
};
