<q-card bordered flat>
    <q-card-section>

        <q-list>
            <q-expansion-item label="SERVER">
                {{server|raw}}
            </q-expansion-item>
        </q-list>

    </q-card-section>
</q-card>

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
