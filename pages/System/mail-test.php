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
        $schema->addFormKit("elFormInput", [
            "label" => "Subject",
            "name" => "subject",
            "validation" => "required"
        ]);

        $schema->addFormKit("elFormInput", [
            "label" => "From",
            "name" => "from",
            "validation" => "required|email"
        ]);

        $schema->addFormKit("elFormInput", [
            "label" => "To",
            "name" => "email",
            "validation" => "required|email"
        ]);

        $schema->addFormKit("elFormTextarea", [
            "label" => "Content",
            "name" => "content",
            "validation" => "required"
        ]);


        return [
            "data" => [
                "subject" => "Test Subject",
                "content" => "This is a test email",
            ],
            "schema" => $schema
        ];
    }
};
