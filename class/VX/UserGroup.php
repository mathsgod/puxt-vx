<?php

namespace VX;

class UserGroup extends Model
{
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
