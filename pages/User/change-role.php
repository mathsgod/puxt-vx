<?php

/**
 * @author Raymond Chong
 * @date 2022-12-20 
 */

use VX\Security\Security;
use VX\User;

return new class
{

    function get(VX $vx, Security $security, User $user)
    {

        $stub = require_once dirname(__DIR__) . "/Role/get-data.php";

        $schema = $vx->createSchema();

        $form = $schema->addForm();
        $form->value([
            "user_id" => $user->user_id,
            "roles" => $user->getRoles()
        ]);
        $form->action("/auth/change-role");


        $form->addHidden("user_id");

        $tree = $form->addElTree("roles")
            ->showCheckbox()
            ->defaultExpandAll()
            ->nodeKey("name");
            

        $data = $stub->get($vx, $security);
        $tree->data($data);


        return $schema;
    }
};
