{{view|raw}}
<?php
return ["get" => function (VX $context) {
    $v = $context->createView();
    $v->setData($context->object());
    $v->add("First name", "first_name");
    $v->add("Last name", "last_name");
    $v->add("Username", "username");
    $v->add("Phone", "phone");
    $this->view = $v;
}];
