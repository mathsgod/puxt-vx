<?php

namespace VX;

use R\ORM\Model as ORMModel;
use ReflectionClass;

class Model extends ORMModel implements IModel
{

    public static $_vx;

    public static $db;
    public static function __db()
    {
        return self::$db;
    }

    //load or create
    public static function LoadOrCreate(?int $id): static
    {
        $key = static::_key();
        if ($obj = static::Query([$key => $id])->first()) {
            return $obj;
        }

        return new static;
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

    public function save()
    {
        $key = $this->_key();

        if (!$this->$key) { //insert
            if (property_exists($this, "created_time")) {
                $this->created_time = date("Y-m-d H:i:s");
            }

            self::$_vx->trigger("before_insert", $this);
            $ret = parent::save();
            self::$_vx->trigger("after_insert", $this);
        } else {
            if (property_exists($this, "updated_time")) {
                $this->updated_time = date("Y-m-d H:i:s");
            }

            self::$_vx->trigger("before_update", $this);
            $ret = parent::save();
            self::$_vx->trigger("after_update", $this);
        }
        return $ret;
    }

    public function delete()
    {
        self::$_vx->trigger("before_delete", $this);
        $ret = parent::delete();
        self::$_vx->trigger("after_delete", $this);


        return $ret;
    }
}
