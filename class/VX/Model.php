<?php

namespace VX;

use R\ORM\Model as ORMModel;
use ReflectionClass;

class Model extends ORMModel implements IModel
{

    public static $db;
    public static function __db()
    {
        return self::$db;
    }

    public function canDeleteBy(User $user): bool
    {
        return true;
    }

    public function canReadBy(User $user): bool
    {
        return true;
    }

    public function canUpdateBy(User $user): bool
    {
        return true;
    }

    public function uri(string $name = null): string
    {
        $reflect = new ReflectionClass($this);
        $uri = $reflect->getShortName();

        $key = $key = self::_key();
        if ($this->$key) {
            $uri .= "/" . $this->$key;
        }
        if (isset($name)) {
            $uri .= "/" . $name;
        }

        return "/" . $uri;
    }
}
