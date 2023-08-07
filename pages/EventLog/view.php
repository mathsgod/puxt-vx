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
        $schema = $vx->createSchema();


        $div = $schema->addElement("div")->attrs(["class" => "row q-col-gutter-md"]);
        $list = $div->addElement("div")->attrs(["class" => "col-12 col-md-6"])->addQCard()->flat()
            ->addQList()->separator();

        $item = $list->addQItem();
        $item->addSection("Eventlog id");
        $item->addSection($eventlog->eventlog_id)->side();

        $item = $list->addQItem();
        $item->addSection("Class");
        $item->addSection($eventlog->class)->side();

        $item = $list->addQItem();
        $item->addSection("Action");
        $item->addSection($eventlog->action)->side();

        $item = $list->addQItem();
        $item->addSection("Created time");
        $item->addSection($eventlog->created_time)->side();


        $card = $div->addElement("div")->attrs(["class" => "col-12"])->addQCard()->flat();
        $card->addSection()->addChildren("Source");
        $card->addSection()->addElement("pre")->addChildren(json_encode($eventlog->source, JSON_PRETTY_PRINT));

        $card = $div->addElement("div")->attrs(["class" => "col-12"])->addQCard()->flat();
        $card->addSection()->addChildren("Target");
        $card->addSection()->addElement("pre")->addChildren(json_encode($eventlog->target, JSON_PRETTY_PRINT));

        return $schema;
    }
};
