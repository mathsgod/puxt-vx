<?php

/**
 * @author Raymond Chong
 * @date 2023-02-01 
 */

use VX\User;

return new class
{

    public function get(VX $vx, User $user)
    {
        if (!$vx->isGranted("update", $user)) {
            throw new \Exception("You are not allowed to view this page");
        }

        $schema = $vx->createSchema();
        $form = $schema->addForm();
        $form->action($user->uri());
        $form->value([
            "username" => $user->username,
            "first_name" => $user->first_name,
            "last_name" => $user->last_name,
            "email" => $user->email,
            "phone" => $user->phone,
            "address1" => $user->address1,
            "address2" => $user->address2,
            "address3" => $user->address3,
            "join_date" => $user->join_date,
            "status" => $user->status,
            "expiry_date" => $user->expiry_date,
            "language" => $user->language,
            "default_page" => $user->default_page,
        ]);

        $row = $form->addRow();
        $col = $row->addCol()->md(12);
        $col->addInput("Username", "username")->validation("required");
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
        $form->addSelect("Status", "status")->options(["Active", "Inactive"])->validation("required");
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

        return $schema;
    }
};
