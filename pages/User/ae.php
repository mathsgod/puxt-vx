{{form|raw}}

<?php

use VX\User;

return ["get" => function (VX $context) {

    $form = $context->createForm();

    $form->add("Username")->input("username")->required();
    $form->add("First name")->input("first_name")->required();
    $form->add("Last name")->input("last_name");
    $form->add("Password")->password("password")->required();
    $form->add("Phone")->input("phone");
    $form->add("Email")->input("email")->required();

    $form->add("Address")->input("addr1");
    $form->add("")->input("addr2");
    $form->add("")->input("addr3");

    $form->add("Join date")->date("join_date");

    $form->add("Status")->select("status", User::STATUS)->required();

    $form->add("Expiry date")->date("expiry_date");

//    $form->add("Language")->select("language", $context->languages);

    $form->add("Default page")->input("default_page");

    $form->setAction($context->route->path);

    $this->form = $form;
}, "post" => function (VX $context) {


    print_R($context->req->getParsedBody());

    print_r($context);
}];
