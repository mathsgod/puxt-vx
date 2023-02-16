<?php

/**
 * @author Raymond Chong
 * @date 2022-12-30 
 */

use Laminas\Diactoros\Response\EmptyResponse;
use VX\Security\RoleRepositoryInterface;
use VX\User;
use VX\UserRole;

return new class
{
    function post(VX $vx)
    {
        $user = User::Create([
            "username" => $vx->_post["username"],
            "first_name" => $vx->_post["first_name"],
            "last_name" => $vx->_post["last_name"],
            "email" => $vx->_post["email"],
            "phone" => $vx->_post["phone"],
            "password" => password_hash($vx->_post["password"], PASSWORD_DEFAULT),
            "address1" => $vx->_post["address1"],
            "address2" => $vx->_post["address2"],
            "address3" => $vx->_post["address3"],
            "join_date" => $vx->_post["join_date"],
            "status" => intval($vx->_post["status"]),
            "expiry_date" => $vx->_post["expiry_date"],
            "language" => $vx->_post["language"],
            "default_page" => $vx->_post["default_page"],
        ]);

        $user->save();
        foreach ($vx->_post["role"] as $role) {

            //only admin can add admin
            if ($role == "Administrators" && !$vx->user->is("Administrators")) continue;

            UserRole::Create([
                "user_id" => $user->user_id,
                "role" => $role
            ])->save();
        }

        return new EmptyResponse(200);
    }

    public function get(VX $vx, RoleRepositoryInterface $roles)
    {
        $schema = $vx->createSchema();
        $form = $schema->addForm();
        $form->action("/User/add");
        $form->value([
            "status" => 0,
            "language" => "en",
            "join_date" => date("Y-m-d"),
            "role" => ["Users"],
        ]);

        $row = $form->addRow();

        $col = $row->addCol()->md(12);
        
        $col->addInput("Username", "username")->validation("required");
        $col->addPassword("Password", "password")
            ->validation($vx->getPasswordValidation())
            ->validationMessages($vx->getPasswordValidationMessages());

        $col->addInput("First name", "first_name")->validation("required");
        $col->addInput("Last name", "last_name");

        $col->addInput("Email", "email")->validation("required|email");

        $col = $row->addCol()->md(12);
        $col->addInput("Phone", "phone");
        $col->addInput("Address 1", "address1");
        $col->addInput("Address 2", "address2");
        $col->addInput("Address 3", "address3");
        
        $form->addDatePicker("Join date", "join_date")->validation("required");
        $form->addDatePicker("Expiry date", "expiry_date");
        $form->addSelect("Status", "status")->options([
            [
                "label" => "Active",
                "value" => 0
            ],
            [
                "label" => "Inactive",
                "value" => 1
            ]
        ])->validation("required");
        $form->addSelect("Language", "language")->options([
            [
                "label" => "English",
                "value" => "en"
            ],
            [
                "label" => "中文",
                "value" => "zh-hk"
            ]
        ])->validation("required");
        $form->addInput("Default page", "default_page");


        $rs = [];
        foreach ($roles->findAll() as $r) {
            if ($r->getName() == "Everyone") continue;
            if ($r->getName() == "Guests") continue;
            if ($r->getName() == "Administrators" && !$vx->user->is("Administrators")) continue;
            $rs[] = [
                "label" => $r->getName(),
                "value" => $r->getName()
            ];
        }

        $form->addSelect("Role", "role")->options($rs)->validation("required")->multiple();



        return $schema;
    }
};
