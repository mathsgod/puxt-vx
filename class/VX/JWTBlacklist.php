<?php

namespace VX;

class JWTBlacklist extends Model
{
    public static function Add(string $jti, int $exp)
    {
        self::Create([
            'jti' => $jti,
            'exp' => $exp
        ])->save();
    }

    public static function InList(string $jti)
    {
        //remove expired tokens
        $q = self::Query();
        $q->where->lessThanOrEqualTo('exp', time());
        $q->delete();

        return self::Query([
            "jti" => $jti
        ])->count() > 0;
    }
}
