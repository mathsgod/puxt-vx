{{table|raw}}
<?php

use VX\MailLog;
use VX\UI\Table;

return new class
{
    function get(VX $vx)
    {
        $table = $vx->ui->createTable("data");
        $table->setDefaultSort("maillog_id", Table::SORT_ORDER_DESC);

        $template = $table->addExpand();
        $template->innerHTML = "<div v-html='props.row.body'></div>";

        $table->add("ID", "maillog_id")->sortable();
        $table->add("From", "from")->sortable()->searchable();
        $table->add("To", "to")->sortable();
        $table->add("Subject", "subject")->sortable()->searchable();
        $table->add("Created time", "created_time")->sortable()->searchable("date");


        $this->table = $table;
    }

    function data(VX $vx)
    {
        $r = $vx->ui->createTableResponse();
        $r->source = MailLog::Query();
        $r->add("maillog_id");
        $r->add("from");
        $r->add("to");
        $r->add("subject");
        $r->add("created_time");
        $r->add("body");
        return $r;
    }
};
