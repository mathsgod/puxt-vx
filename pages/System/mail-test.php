{{v|raw}}
<?php

/**
 * Created by: Raymond Chong
 * Date: 2021-07-27 
 */
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
    }

    function get(VX $vx)
    {


        $v = $vx->ui->createForm([
            "from" => "no-reply@" . $_SERVER["SERVER_NAME"],
            "subject" => "Testing mail subject",
            "content" => "This is testing content."
        ]);
        $v->add("Subject")->input("subject")->required();
        $v->add("From")->email("from")->required();
        $v->add("Email")->email("email")->required();
        $v->add("Content")->textarea("content");

        $this->v = $v;
    }
};
