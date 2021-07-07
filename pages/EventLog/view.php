<vx-card>
    <vx-card-body>
        {{view|raw}}
    </vx-card-body>
</vx-card>
<?php

/**
 * Created by: Raymond Chong
 * Date: 2021-07-05 
 */
return new class
{
    function get(VX $vx)
    {
        $v = $vx->ui->createView();
        $v->add("Eventlog id", "eventlog_id");
        $v->add("Action", "action");
        $v->add("Created time", "created_time");
        $v->add("ID", "id");
        $v->add("Class", "class");

        //$v->add("Different");

        $v->add("Source", function ($o) {
            return "<pre>" . json_encode($o->source, JSON_PRETTY_PRINT) . "</pre>";
        });

        $v->add("Target", function ($o) {
            return "<pre>" . json_encode($o->target, JSON_PRETTY_PRINT) . "</pre>";
        });
        $this->view = $v;
    }
};
