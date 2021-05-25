<el-card>
    {{form|raw}}
</el-card>

<?php

return ["get" => function (VX $context) {

    $form = $context->createForm();

    $form->add("Username")->input("username")->required();
    $form->add("First name")->input("first_name")->required();
    $form->add("Last name")->input("last_name");
    $form->add("Password")->password("password")->required();

    $form->setAction($context->route->path);

    $this->form = $form;
}, "post" => function (VX $context) {

    
    print_R($context->req->getParsedBody());

    print_r($context);
}];
