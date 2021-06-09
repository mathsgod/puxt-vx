<?php

namespace VX;

class UserGroup extends Model
{
    public function removeUser(User $user)
    {
        foreach ($user->UserList() as $ul) {
            if ($ul->usergroup_id == $this->usergroup_id) {
                $ul->delete();
            }
        }
        return;
    }

    public function hasUser(User $user): bool
    {
        foreach ($user->UserList() as $ul) {
            if ($ul->usergroup_id == $this->usergroup_id) return true;
        }
        return false;
    }

    public function addUser(User $user)
    {
        //check if exists
        if ($ul = UserList::Query([
            "usergroup_id" => $this->usergroup_id,
            "user_id" => $user->user_id
        ])->first()) {
            return $ul;
        }

        $ul = new UserList();
        $ul->user_id = $user->user_id;
        $ul->usergroup_id = $this->usergroup_id;
        $ul->save();
        return $ul;
    }


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

    public function __toString()
    {
        return $this->name;
    }
}
