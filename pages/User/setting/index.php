<?php

/**
 * @author Raymond Chong
 * @date 2023-01-19 
 */

use FormKit\Schema;

return new class
{
    function get(VX $vx)
    {

        $schema = $vx->createSchema();

        $form = $schema->addForm();
        $form->showBack(false);

        $form->action($vx->user->uri());

        $form->value([
            "username" => $vx->user->username,
            "email" => $vx->user->email,
            "first_name" => $vx->user->first_name,
            "last_name" => $vx->user->last_name,
        ]);

        $form->header("General");

        $form->addInput("Username", "username")->validation("required");
        $form->addInput("Email", "email")->validation("required|email");
        $form->addInput("First name", "first_name")->validation("required");
        $form->addInput("Last name", "last_name");

        return $schema;
    }
};
