<?php

namespace VX;

use Exception;

class AuthLock extends Model
{
    public static function IsLockedIP(string $ip, int $time): bool
    {
        return self::Query(["ip" => $ip])
            ->where("value>=3")
            ->where("date_add(`time`,Interval " . $time . " second) > now()")
            ->count() > 0;
    }

    public static function ClearLockedIP(string $ip)
    {
        $a = self::Query(["ip" => $ip])->first();

        if ($a) {
            $a->delete();
        }
    }

    public static function LockIP(string $ip)
    {

        $a = AuthLock::Query(["ip" => $ip])->first();

        if ($a) {
            $a->value++;
        } else {
            $a = AuthLock::Create([
                "ip" => $ip,
                "value" => 1,
            ]);
        }
        $a->time = date("Y-m-d H:i:s");

        //no checking
        $a->save();
    }
}
