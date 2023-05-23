<?php

namespace VX;

class AuthLock extends Model
{
    public static function IsLocked(string $ip, string $identity): bool
    {
        $q = self::Query(["ip" => $ip, "identity" => $identity]);
        $q->where->expression("expiry >?", [date("Y-m-d H:i:s")]);
        return $q->count() > 0;
    }

    public static function Clear(string $ip, string $identity)
    {
        foreach (self::Query(["ip" => $ip, "identity" => $identity]) as $a) {
            $a->delete();
        }
    }

    public static function Add(string $ip, string $identity)
    {
        $a = AuthLock::Get([
            "ip" => $ip,
            "identity" => $identity
        ]);

        if (!$a) {
            $a = AuthLock::Create([
                "ip" => $ip,
                "identity" => $identity,
                "value" => 1
            ]);
        } else {
            $a->value++;
        }
        $a->time = date("Y-m-d H:i:s");

        if ($a->value % 5 == 0) {
            //value/5 1=15 ,2=20, 3=25
            $times = 10 + ($a->value / 5) * 5;
            $a->expiry = date("Y-m-d H:i:s", strtotime("+{$times} minutes"));
        }


        $a->save();
    }
}
