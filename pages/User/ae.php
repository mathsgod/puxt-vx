{{form|raw}}

<?php

use VX\User;
use VX\UserGroup;

return new class
{
    function get(VX $context)
    {

        $obj = $context->object();
        if (!$obj->user_id) {
            $obj->join_date = date("Y-m-d");
            $obj->_usergroup_id = [3];
            $obj->language = "en";
        } else {
            $obj->_usergroup_id = [];
            foreach ($obj->UserGroup() as $ug) {
                $obj->_usergroup_id[] = $ug->usergroup_id;
            }
        }

        $form = $context->ui->createForm($obj);

        $form->add("Username")->input("username")->required();
        $form->add("First name")->input("first_name")->required();
        $form->add("Last name")->input("last_name");


        if (!$obj->user_id) {
            $form->add("Password")->password("password")->required();
        }

        $form->add("Phone")->input("phone");
        $form->add("Email")->input("email")->required();

        $form->add("Address")->input("addr1");
        $form->add("")->input("addr2");
        $form->add("")->input("addr3");

        $form->add("Join date")->date("join_date")->required();

        $form->add("Status")->select("status", User::STATUS)->required();

        $form->add("Expiry date")->date("expiry_date");

        $form->add("Language")->select("language", $context->config["VX"]["language"])->required();

        $form->add("Default page")->input("default_page");

        $form->add("User group")->multiSelect("_usergroup_id")->option(UserGroup::Query(), "name", "usergroup_id");


        $form->setAction($obj->uri("ae"));

        $this->form = $form;
    }

    function post(VX $vx)
    {

        $obj = $vx->postForm();

        $post = $vx->req->getParsedBody();

        foreach ($obj->UserGroup() as $ug) {
            $ug->removeUser($obj);
        }

        foreach ($post["_usergroup_id"] as $uid) {
            $ug = new UserGroup($uid);
            $ug->addUser($obj);
        }

        $vx->res->redirect($obj->uri("view"));
        $vx->res->code(201);
    }

    function patch(VX $vx)
    {
        $obj = $vx->object();
        $obj->bind($vx->_post);
        $obj->save();

        foreach ($obj->UserGroup() as $ug) {
            $ug->removeUser($obj);
        }

        foreach ($vx->_post["_usergroup_id"] as $uid) {
            $ug = new UserGroup($uid);
            $ug->addUser($obj);
        }

        $vx->res->redirect($obj->uri("view"));
        $vx->res->code(204);
    }
};
