<?php

namespace VX;

class UserGroup extends Model
{

    public static function GetByNameOrCode(string $name): ?self
    {
        $ug = self::Query()
            ->where("name=:name or code=:code", ["name" => $name, "code" => $name])
            ->first();
        return $ug;
    }

    public function canUpdateBy(User $user): bool
    {
        if ($this->readonly) {
            return false;
        }
        return parent::canUpdateBy($user);
    }

    public function canDeleteBy(User $user): bool
    {
        if ($this->readonly) {
            return false;
        }
        return parent::canDeleteBy($user);
    }
}
