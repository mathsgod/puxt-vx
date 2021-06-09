<vx-card>
    {{view|raw}}
</vx-card>
<?php
return ["get" => function (VX $context) {


    $view = $context->createView();
    $view->add("Name", "name");
    //$view->add("Code", "code");
    $view->add("Remark", "remark");

    $this->view = $view;
}];
