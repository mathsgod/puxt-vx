<?php

namespace VX;

use Laminas\EventManager\EventManagerAwareInterface;
use Laminas\EventManager\EventManagerInterface;
use Laminas\Permissions\Acl\Resource\ResourceInterface;
use R\DB\Model as DBModel;
use ReflectionClass;

class Model extends DBModel implements ResourceInterface, IModel
{

    static $_event;
    public function setEventManager(EventManagerInterface $eventManager)
    {
        self::$_event = $eventManager;
    }

    static $_db;
    public static function __db()
    {
        return self::$_db;
    }

    public function getEventManager()
    {
        return self::$_event;
    }

    /**
     * @var \VX $_vx
     */
    public static $_vx;


    public function _id()
    {
        $key = static::_key();
        return $this->$key;
    }

    public function getResourceId()
    {
        $r = new ReflectionClass(static::class);
        return $r->getShortName();
    }


    public function canDeleteBy(User $user): bool
    {
        return self::$_vx->getAcl()->isAllowed($user, $this, "delete");
    }

    public function canReadBy(User $user): bool
    {
        return self::$_vx->getAcl()->isAllowed($user, $this, "read");
    }

    public function canUpdateBy(User $user): bool
    {
        return self::$_vx->getAcl()->isAllowed($user, $this, "update");
    }

    public function createdBy(): ?User
    {
        if ($this->created_by) {
            return User::Load($this->created_by);
        }
        return null;
    }

    public function updatedBy(): ?User
    {
        if ($this->updated_by) {
            return User::Load($this->updated_by);
        }
        return null;
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

    public function __call($function, $args)
    {
        $class = get_class($this);

        //check const
        $c = new \ReflectionClass($class);
        if ($const = $c->getConstants()) {

            $decamlize = function ($string) {
                return strtolower(preg_replace(['/([a-z\d])([A-Z])/', '/([^_])([A-Z][a-z])/'], '$1_$2', $string));
            };
            $field = $decamlize($function);

            if (array_key_exists(strtoupper($field), $const)) {
                return $const[strtoupper($field)][$this->$field];
            }

            if (array_key_exists($function, $const)) {
                return $const[$function][$this->$field];
            }
        }
        return parent::__call($function, $args);
    }
}
