<?php

/**
 * @author Raymond Chong
 * @date 2023-02-01 
 */

use VX\User;

return new class
{
    function get(VX $vx)
    {
        $user = User::FromGlobal();

        if (!$vx->isGranted("read", $user)) {
            throw new \Exception("You are not allowed to view this page");
        }

        $scheam = $vx->createSchema();

        $form = $scheam->addForm();

        $form->addPassword("New password", "password")
            ->validation($vx->getPasswordValidation())
            ->validationMessages($vx->getPasswordValidationMessages());

        $form->addPassword("Confirm password", "password_confirm")->validation("required|confirm");

        return $scheam;
    }
};
