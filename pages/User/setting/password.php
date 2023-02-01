<?php

/**
 * @author Raymond Chong
 * @date 2023-02-01 
 */

use Laminas\Diactoros\Response\EmptyResponse;
use League\Route\Http\Exception\BadRequestException;
use League\Route\Http\Exception\ForbiddenException;
use VX\Security\Security;

return new class
{
    function post(VX $vx, Security $security)
    {
        $user = $vx->user;

        if (!$security->isGranted($user, "user.can_change_password", $user)) {
            throw new ForbiddenException("You are not allowed to change password");
        }

        if (!password_verify($vx->_post["old_password"], $user->password)) {
            throw new BadRequestException("Old password is incorrect");
        }

        if (!$vx->isValidPassword($vx->_post["password"])) {
            throw new BadRequestException("Password is not valid");
        }

        $user->password = password_hash($vx->_post["password"], PASSWORD_DEFAULT);
        $user->save();

        return new EmptyResponse();
    }

    function get(VX $vx)
    {
        $schema = $vx->createSchema();

        $form = $schema->addForm();

        $form->action("/User/setting/password");

        $form->addPassword("Old password", "old_password")->validation("required");
        $form->addPassword("New password", "password")
            ->validation($vx->getPasswordValidation())
            ->validationMessages($vx->getPasswordValidationMessages());

        $form->addPassword("Confirm password", "password_confirm")->validation("required|confirm");


        $messages = $vx->getPasswordValidationMessages();

        if (count($messages)) {
            $form->addElement("h3")->addChildren("Password requirements");
            $div = $form->addElement("div")->attrs(["class" => "alert alert-info"]);

            foreach ($messages as $k => $v) {
                $div->addElement("p")->addChildren($v);
            }
        }

        return $schema;
    }
};
