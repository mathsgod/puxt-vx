<?php

/**
 * @author Raymond Chong
 * @date 2023-01-30 
 */
return new class
{
    function get(VX $vx)
    {

        $schema = $vx->createSchema();

        $schema->addComponent("VxColumn", [
            "label" => "ID",
            "prop" => "maillog_id",
            "sortable" => true,
            "width" => 100,
        ]);

        $schema->addComponent("VxColumn", [
            "label" => "From",
            "prop" => "from",
            "sortable" => true,
            "searchable" => true,
        ]);

        $schema->addComponent("VxColumn", [
            "label" => "To",
            "prop" => "to",
            "sortable" => true,
            "searchable" => true,
        ]);

        $schema->addComponent("VxColumn", [
            "label" => "Subject",
            "prop" => "subject",
            "sortable" => true,
            "searchable" => true,
        ]);

        $schema->addComponent("VxColumn", [
            "label" => "Time",
            "prop" => "created_time",
            "sortable" => true,
            "searchable" => true,
            "search-type" => "date"
        ]);

        return ["schema" => $schema];
    }
};
