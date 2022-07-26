<?php

/**
 * Created by: Raymond Chong
 * Date: 2021-07-27 
 */

use Laminas\Diactoros\Response\EmptyResponse;

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
};
