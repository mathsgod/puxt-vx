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

        $id = $obj->_id();
        $class = $el->class;
        $org = new $class($id);
        $el->source = $org;
        $el->target = $obj;
        $el->id = $id;
        $el->save();
    }

    public static function LogDelete(ORMModel $obj, User $user)
    {
        if ($obj instanceof self) return;

        $ro = new ReflectionObject($obj);
        $el = new self;
        $el->user_id = $user->user_id;
        $el->class = $ro->getName();
        $el->action = "Delete";
        $el->source = $obj;
        $el->id = $obj->_id();
        $el->save();
    }
}
