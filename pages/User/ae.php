{{form|raw}}

<?php

use VX\User;
use VX\UserGroup;

return new class
{
    function get(VX $vx)
    {
        $obj = User::FromGlobal();
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

        $form = $vx->ui->createForm($obj);

        $form->add("Username")->input("username")->required();
        $form->add("First name")->input("first_name")->required();
        $form->add("Last name")->input("last_name");


        if (!$obj->user_id) {

            $formItem = $form->add("Password");
            $formItem->password("password")->required();
            $formItem->setAttribute(":rules", json_encode($vx->getPasswordPolicy()));
        }

        $form->add("Phone")->input("phone");
        $form->add("Email")->input("email")->required();

        $form->add("Address")->input("addr1");
        $form->add("")->input("addr2");
        $form->add("")->input("addr3");

        $form->add("Join date")->date("join_date")->required();

        $select = $form->add("Status")->select("status", User::STATUS)->clearable(false)->required();

        $form->add("Expiry date")->date("expiry_date");

        $form->add("Language")->select("language", $vx->config["VX"]["language"])->clearable(false)->required();

        $form->add("Default page")->input("default_page");

        $ugs = UserGroup::Query();
        if (!$vx->user->isAdmin()) {
            $ugs->where->notIn("usergroup_id", [1, 4]);//admin, guest
        }
        $form->add("User group")->multiSelect("_usergroup_id")->option($ugs, "name", "usergroup_id");


        $form->setAction($obj->uri("ae"));

        $form->setSuccessUrl("/User");
        $this->form = $form;
    }

    function post(VX $vx)
    {
        $obj = User::FromGlobal();
        $obj->bind($vx->_post);
        $obj->password = password_hash($vx->_post["password"], PASSWORD_DEFAULT);
        $obj->save();

        $post = $vx->_post;

        foreach ($post["_usergroup_id"] as $uid) {
            $ug = UserGroup::Get($uid);
            $ug->addUser($obj);
        }
    }

    function patch(VX $vx)
    {
        $obj = User::FromGlobal();
        $obj->bind($vx->_post);
        $obj->save();

        foreach ($obj->UserGroup() as $ug) {
            $ug->removeUser($obj);
        }

        foreach ($vx->_post["_usergroup_id"] as $uid) {
            $ug = UserGroup::Get($uid);
            $ug->addUser($obj);
        }

        $vx->res->redirect($obj->uri("view"));
        $vx->res->code(204);
    }
};
