<el-card>
    <el-collapse>
        <el-collapse-item title="SERVER">
            {{server|raw}}
        </el-collapse-item>
    </el-collapse>
</el-card>

<?php

/**
 * Created by: Raymond Chong
 * Date: 2021-07-30 
 */

use VX\UI\EL\Table;

return new class
{
    function get(VX $vx)
    {
        $table = new Table;

        $data = [];
        foreach ($_SERVER as $name => $value) {
            $data[] = [
                "name" => $name,
                "value" => $value
            ];
        }
        $table->setData($data);
        $table->setSize(Table::SIZE_SMALL);
        $table->addColumn("Name", "name")->width("200");
        $table->addColumn("Value", "value");
        $this->server = $table;
    }
};
