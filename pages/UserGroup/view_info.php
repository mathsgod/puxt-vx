<vx-card>
    {{view|raw}}
</vx-card>
<?php
return ["get" => function (VX $context) {


    $view = $context->createView();
    $view->add("Name", "name");

    $this->view = $view;
}];
