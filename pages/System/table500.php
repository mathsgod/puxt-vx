{{table|raw}}
<?php
/**
 * Created by: Raymond Chong
 * Date: 2021-09-13 
 */
return new class
{
    function get(VX $vx)
    {
        $table = $vx->ui->createTable("getData");
        $table->add("Name", "name");

        $this->table = $table;
    }

    function getData()
    {

        http_response_code(500);
    }
};
