<vue>
    {{dd|raw}}
</vue>

{{dd}}
<?php

/**
 * Created by: Raymond Chong
 * Date: 2021-10-18 
 */

use VX\UI\EL\Dropdown;
use VX\UI\EL\DropdownMenu;

return new class
{
    function get(VX $vx)
    {

        $dd = new Dropdown;
        $dd->setSplitButton(true);

        $dd->append("test");

        $dd->setDropdownMenu(function (DropdownMenu $ddm) {

            $item = $ddm->addItem();
            $item->append("item1");

            $item = $ddm->addItem();
            $item->append("item2");
            $item->setDivided(true);

            $item = $ddm->addItem();
            $item->append("goto user");
            $item->setCommand("/User");
        });

        $dd->onCommand('$router.push($event)');



        $this->dd = $dd;
    }
};
