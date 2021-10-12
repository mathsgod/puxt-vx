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


return new class
{
    function get(VX $vx)
    {


        $data = [];
        foreach ($_SERVER as $name => $value) {
            $data[] = [
                "name" => $name,
                "value" => $value
            ];
        }
        $table = $vx->ui->createT($data);
        $table->setSize("small");
        $table->add("Name", "name")->width("200");
        $table->add("Value", "value");
        $this->server = $table;
    }
};
