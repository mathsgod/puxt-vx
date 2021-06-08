{{form|raw}}
<?php
return ["get" => function (VX $context) {
    $form = $context->createForm();
    $form->add("Name")->input("name")->required();
    $form->add("Remark")->textarea("remark");
    $this->form = $form;
}, "post" => function (VX $context) {
    $obj = $context->postForm();
    yield $context->res->message("Created ");
    yield $context->res->redirect($obj->uri("view"));
}];
