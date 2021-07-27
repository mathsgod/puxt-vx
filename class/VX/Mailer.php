<?php

namespace VX;

use PHPMailer\PHPMailer\PHPMailer;

class Mailer extends PHPMailer
{

    public function __construct()
    {
        parent::__construct(true);
        $this->CharSet = "UTF-8";
    }
}
