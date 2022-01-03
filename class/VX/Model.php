<?php

namespace VX;

use Exception;
use Laminas\EventManager\EventManagerAwareInterface;
use Laminas\EventManager\EventManagerInterface;
use Laminas\Permissions\Acl\Resource\ResourceInterface;
use R\DB\Model as DBModel;
use ReflectionClass;

class Model extends DBModel implements ResourceInterface, IModel
{

    public static function FromGlobal(): static
    {
        $vx = self::$_vx;
        return $vx->object();
    }

    static $_db;
    public static function __db()
    {
        return self::$_db;
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

    public function canCreateBy(User $user): bool
    {
        return self::$_vx->getAcl()->isAllowed($user, $this, "create");
    }

    public function createdBy(): ?User
    {
        if ($this->created_by) {
            return User::Get($this->created_by);
        }
        return null;
    }

    public function updatedBy(): ?User
    {
        if ($this->updated_by) {
            return User::Get($this->updated_by);
        }
        return null;
    }

    public function uri(?string $name = null): string
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
