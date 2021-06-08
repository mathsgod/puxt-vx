<?php

namespace VX;

use R\ORM\Model as ORMModel;
use ReflectionObject;

class EventLog extends Model
{
    public static function LogInsert(ORMModel $obj, User $user)
    {
        if ($obj instanceof self) return;

        $ro = new ReflectionObject($obj);
        $el = new EventLog();
        $el->user_id = $user->user_id;
        $el->class = $ro->getName();
        $el->action = 'Insert';
        $el->target = $obj;
        $el->id = $obj->_id();
        $el->save();
    }

    public static function LogUpdate(ORMModel $obj, User $user)
    {
        if ($obj instanceof self) return;

        $ro = new ReflectionObject($obj);
        $el = new EventLog();
        $el->user_id = $user->user_id;
        $el->class = $ro->getName();
        $el->action = "Update";

        $class = $el->class;
        $org = new $class($obj->_id());
        $el->source = $org;
        $el->target = $obj;
        $el->save();
    }

    public static function LogDelete(ORMModel $obj, User $user)
    {
        if ($obj instanceof self) return;

        $ro = new ReflectionObject($obj);
        $el = new self;
        $el->user_id = $user->user_id;
        $el->class = $ro->getName();
        $el->action = "Update";
        $el->source = $obj;
        $el->save();
    }
}
