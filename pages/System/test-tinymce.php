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
        outp($vx->_post);
    }

    function get(VX $vx)
    {
        $form = $vx->ui->createForm([
            "content" => "<a href='https://www.google.com'><div class='test'>aaa</div></a>",
            "content_2" => "2222222",
            "content_3" => "333333"
        ]);

        $form->setAction();

        $tinymce = $form->add("tinymce", ["col" => 12])->tinymce("content");
        $tinymce->setAttribute("api-key", "bfqasodzk1neqa8lmfym5h5x913j7u199hy7rm90a7p30ozn");
        $tinymce->setAttribute(":height", 300);
        $tinymce->setAttribute("base-url", "http://192.168.88.108:8001/vx/uploads/");


        $tinymce = $form->add("tinymce2", ["col" => 12])->tinymce("content_2");
        $tinymce = $form->add("tinymce3", ["col" => 12])->tinymce("content_3");

        //$form->add("text1")-
        $this->form = $form;
    }
};
