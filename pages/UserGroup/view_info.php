{{view|raw}}
<?php
return ["get" => function (VX $context) {

    $obj = $context->object();
    $view = $context->createView();
    $view->addItem("Name")->setContent($obj->name);

    $this->view = $view;
}];
