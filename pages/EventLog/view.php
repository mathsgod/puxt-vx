<?php

/**
 * @author Raymond Chong
 * @date 2023-01-31 
 */

use VX\EventLog;

return new class
{
    function get(VX $vx, EventLog $eventlog)
    {
        $scheam = $vx->createSchema();

        $desc = $scheam->addDescriptions()->border()->column(1);

        $desc->addItem("Eventlog id", $eventlog->eventlog_id);
        $desc->addItem("Class", $eventlog->class);
        $desc->addItem("Action", $eventlog->action);
        $desc->addItem("Created time", $eventlog->created_time);

        $item = $desc->addItem("Source");
        $item->addElement("pre")->addChildren(json_encode($eventlog->source, JSON_PRETTY_PRINT));

        $item = $desc->addItem("Target");
        $item->addElement("pre")->addChildren(json_encode($eventlog->target, JSON_PRETTY_PRINT));

        return $scheam;
    }
};
