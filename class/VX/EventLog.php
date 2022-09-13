<?php

namespace VX;

use Laminas\Db\Sql\Expression;
use R\DB\Query;
use ReflectionObject;
use TheCodingMachine\GraphQLite\Annotations\Field;

class EventLog extends Model
{
    #[Field()]
    public function User()
    {
        return User::Get($this->user_id);
    }

    public static function Sort(Query $q, string $sort, string $order)
    {
        if ($sort == "User.username") {
            $q->order(new Expression("(select username from User where user_id=EventLog.user_id) $order"));
        }
    }

    public static function Filter(Query $q, string $filter, string $operator, $value)
    {
        if ($filter == "User.username") {
            $q->where->expression("user_id in (select user_id from User where username like ?)", ["%$value%"]);
            
        }
    }


    public static function LogInsert($obj, User $user)
    {
        if ($obj instanceof self) return;

        $ro = new ReflectionObject($obj);
        $el = EventLog::Create();
        $el->user_id = $user->user_id;
        $el->class = $ro->getName();
        $el->action = 'Insert';
        $el->target = $obj;
        $el->id = $obj->_id();
        $el->save();
    }

    private static function FindDifferent(array $source, array $target)
    {
        $a = array_diff_assoc($source, $target);
        $b = array_diff_assoc($target, $source);

        $diff = [];
        foreach ($a as $name => $value) {
            $diff[] = [
                "field" => $name,
                "from" => $b[$name],
                "to" => $value
            ];
        }

        return $diff;
    }

    public static function LogUpdate($obj, User $user)
    {
        if ($obj instanceof self) return;

        $ro = new ReflectionObject($obj);
        $el = EventLog::Create();
        $el->user_id = $user->user_id;
        $el->class = $ro->getName();
        $el->action = "Update";


        $id = $obj->_id();
        $class = $el->class;
        $org = new $class($id);
        $el->source = $org;
        $el->target = $obj;
        $el->id = $id;


        //$el->different = self::FindDifferent((array)$org, (array)$obj);

        $el->save();
    }

    public static function LogDelete($obj, User $user)
    {
        if ($obj instanceof self) return;

        $ro = new ReflectionObject($obj);
        $el = self::Create();
        $el->user_id = $user->user_id;
        $el->class = $ro->getName();
        $el->action = "Delete";
        $el->source = $obj;
        $el->id = $obj->_id();
        $el->save();
    }
}
