{{form|raw}}
<?php
return ["get" => function (VX $context) {
    $form = $context->createForm();
    $form->add("Name")->input("name")->required();
    $form->add("Remark")->textarea("remark");
    $this->form = $form;
}, "post" => function (VX $context) {
    $data = $context->req->getParsedBody();

    $obj = $context->object();
    $obj->bind($data);
    $obj->save();
    return [
        "status" => 303,
        "location" => $obj->uri("view")
    ];
}];
