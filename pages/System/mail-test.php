<?php

/**
 * Created by: Raymond Chong
 * Date: 2021-07-27 
 */

use Laminas\Diactoros\Response\EmptyResponse;
use Symfony\Component\Translation\Translator;

return new class
{
    function post(VX $vx)
    {
        $mail = $vx->getMailer();
        $mail->Subject = $vx->_post["subject"];
        $mail->setFrom($vx->_post["from"]);
        $mail->addAddress($vx->_post["email"]);
        $mail->msgHTML($vx->_post["content"]);
        $mail->send();

        return new EmptyResponse();
    }

    function get()
    {
        $schema = new FormKit\Schema;
        $form = $schema->addForm();

        $form->value([
            "subject" => "Test Subject",
            "content" => "This is a test email"
        ]);
        $form->action("/System/mail-test");

        $form->addInput("Subject", "subject")->validation("required");
        $form->addInput("From", "from")->validation("required|email");
        $form->addInput("To", "email")->validation("required|email");
        $form->addTextarea("Content", "content")->validation("required");

        return $schema;
    }
};
