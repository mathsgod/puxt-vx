aaa Username {{Username|trans}}
{{form|raw}}
<?php

/**
 * Created by: Raymond Chong
 * Date: 2021-07-07 
 */

use Symfony\Component\Translation\Loader\ArrayLoader;
use Symfony\Component\Translation\Loader\YamlFileLoader;
use Symfony\Component\Translation\Translator;
use VX\UI\EL\Transfer;

return new class
{
    function post(VX $vx)
    {

        var_dump($vx->_post);
        die();
    }

    function get(VX $vx)
    {

        return;
        echo $vx->translator->trans("Username");
        die();

        $translator = new Translator("zh-hk");

        $translator->addLoader("yaml", new YamlFileLoader());
        $translator->addResource("yaml", __DIR__ . "\messages.zh-hk.yml", "zh-hk");


        $translator->addLoader("array", new ArrayLoader());
        
        $translator->addResource("array", ["Username" => "使用者名稱1"], "zh-hk");
        $translator->addResource("array", ["username" => "Username"], "en");




        echo $translator->trans("username");
        die();


        $form = $vx->ui->createForm(["file" => 'a.jpg', "file2" => "hello", "transfer1" => []]);
        $form->setAction();

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

        $form->add("Rate")->rate("rate1");

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
