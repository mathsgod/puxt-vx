<?php

namespace VX;

use R\ORM\Model as ORMModel;

class Model extends ORMModel
{

    public static $db;
    public static function __db()
    {
        return self::$db;
    }
}
