<?php

/**
 * Created by: Raymond Chong
 * Date: 2021-07-30 
 */
return new class
{
    function getData()
    {
        $data = [];
        foreach ($_SERVER as $name => $value) {
            $data[] = [
                "name" => $name,
                "value" => $value
            ];
        }
        return $data;
    }

    function get(VX $vx)
    {
        $schema = $vx->createSchema();
        $table = $schema->addElTable();
        $table->size("small");
        $table->data($this->getData());
        $table->addColumn()->label("Name")->prop("name")->sortable()->width(200);
        $table->addColumn()->label("Value")->prop("value")->sortable();
        return $schema;
    }
};
