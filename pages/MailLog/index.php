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

        $table = $schema->addVxTable();
        $table->query("MailLog?fields[]=body&sort[]=maillog_id:desc");

        $iframe = $table->addColumn()->type("expand")->addElement("iframe");

        $iframe->attr("srcdoc", '$row.body');

        $table->addColumn("ID", "maillog_id")->sortable()->width(100);
        $table->addColumn("From", "from")->sortable()->searchable();
        $table->addColumn("To", "to")->sortable()->searchable();
        $table->addColumn("Subject", "subject")->sortable()->searchable();
        $table->addColumn("Time", "created_time")->sortable()->searchable()->searchType("date");

        return $schema;
    }
};
