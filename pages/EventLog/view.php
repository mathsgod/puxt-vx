<vx-card>
    <vx-card-body>
        {{view|raw}}
    </vx-card-body>
</vx-card>
<?php
return ["get" => function (VX $vx) {
    $v = $vx->createView();
    $v->add("Eventlog id", "eventlog_id");
    $v->add("Action", "action");
    $v->add("Created time", "created_time");
    $v->add("ID", "id");
    $v->add("Class", "class");

    $v->add("Source", function ($o) {
        return json_encode($o->source);
    });

    $v->add("Target", function ($o) {
        return json_encode($o->target);
    });
    $this->view = $v;
}];
