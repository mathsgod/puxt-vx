<?php

/**
 * @author Raymond Chong
 * @date 2023-02-01 
 */
return new class
{
    function get(VX $vx)
    {
        $scheam = $vx->createSchema();

        $form = $scheam->addForm();

        $form->addPassword("New password", "password")
            ->validation($vx->getPasswordValidation())
            ->validationMessages($vx->getPasswordValidationMessages());

        $form->addPassword("Confirm password", "password_confirm")->validation("required|confirm");
        
        return $scheam;
    }
};
