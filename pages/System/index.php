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

        /*  $lists = $schema->addQCard()->addLists();
        foreach ($this->getData() as $item) {
            $qi = $lists->addQItem();
            $sec = $qi->addSection();
            $sec->addItemLabel()->appendHTML($item["name"]);

            $sec->addItemLabel()->caption()->lines(10)->appendHTML($item["value"]);
            //$lists->item($item["name"], $item["value"]);
        } */
        $table = $schema->addElTable();
        $table->size("small");
        $table->data($this->getData());
        $table->addColumn()->label("Name")->prop("name")->sortable()->width(200);
        $table->addColumn()->label("Value")->prop("value")->sortable();
        return $schema;
    }
};
