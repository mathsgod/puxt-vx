<?php

namespace VX;

class Config extends Model
{
    static function CreateOrLoad(string $name):self
    {
        $r = self::Query(["name" => $name])->first();

        if ($r) return $r;

        $r = new self;
        $r->name = $name;
        return $r;
    }
}
