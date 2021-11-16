<vue>
    {{dialog|raw}}
    {{dialog}}

</vue>

<?php

/**
 * Created by: Raymond Chong
 * Date: 2021-09-10 
 */

use P\HTMLElement;
use P\HTMLTemplateElement;
use VX\UI\Dialog;
use VX\UI\EL\Button;

return new class
{
    function get(VX $vx)
    {

        $dialog = new Dialog;
        $dialog->setTitle("dialog test");

        $dialog->activiator(function (HTMLTemplateElement $template) {
            $button = new Button();
            $button->innerHTML = "dialog";
            $button->setAttribute("v-on", "on");
            $template->append($button);
        });

        $div = new HTMLElement("div", "testing");
        $dialog->append($div);

        $this->dialog = $dialog;

        //sleep(3);
        //$this->a = $vx->_get["a"];
    }
};
