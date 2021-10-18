<vue>
    <el-dropdown split-button type="primary">
        Dropdown List
        <el-dropdown-menu slot="dropdown">
            <el-dropdown-item>Action 1</el-dropdown-item>
            <el-dropdown-item>Action 2</el-dropdown-item>
            <el-dropdown-item>Action 3</el-dropdown-item>
            <el-dropdown-item>Action 4</el-dropdown-item>
            <el-dropdown-item>Action 5</el-dropdown-item>
        </el-dropdown-menu>
    </el-dropdown>
</vue>
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
        });


        $this->dd = $dd;
    }
};
