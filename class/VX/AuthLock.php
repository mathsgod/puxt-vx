<?php

namespace VX;

class AuthLock extends Model
{
    public static function IsLockedIP(string $ip): bool
    {
        return self::Query(["ip" => $ip])
            ->where("value>=3")
            ->where("date_add(`time`,Interval 180 second) > now()")
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

        $a = AuthLock::Query([
            "ip" => $ip
        ])->first();
        if ($a) {
            $a->value++;
        } else {
            $a = new self;
            $a->ip = $ip;
            $a->value = 0;
        }
        $a->time = date("Y-m-d H:i:s");

        //no checking
        $a->save();
    }
}
