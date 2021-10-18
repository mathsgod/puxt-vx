<vue>
    {{c|raw}}
    {{c}}
</vue>

<?php

/**
 * Created by: Raymond Chong
 * Date: 2021-10-18 
 */

use VX\UI\EL\Collapse;

return new class
{
    function get(VX $vx)
    {
        $c = new Collapse;
        //$c->setAccordion(true);
        $c->addItem()->setTitle("c1");
        $c->addItem()->setTitle("c2");
        $this->c = $c;
    }
};
