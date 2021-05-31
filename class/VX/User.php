<?php

namespace VX;

use Exception;

class User extends Model
{

    const STATUS = ["Active", "Inactive"];
    public static function Login(string $username, string $password, $code = null)
    {
        $user = self::Query([
            "username" => $username,
            "status" => 0
        ])->first();

        if (!$user) {
            throw new Exception("user not found");
        }

        //check password
        if (!password_verify($password, $user->password)) {
            throw new Exception("password error");
        }

        if ($user->expiry_date && strtotime($user->expiry_date) < time()) {
            throw new Exception("user expired");
        }

        if ($user->UserList->count() == 0) {
            throw new Exception("no any user group");
        }

        return $user;
    }

    public function __toString()
    {
        return $this->first_name . " " . $this->last_name;
    }


    private static $_is = [];
    public function is(string $name): bool
    {

        $group = UserGroup::GetByNameOrCode($name);
        if (!$group) return false;

        if (isset(self::$_is[$this->user_id])) {
            return in_array($group->usergroup_id, self::$_is[$this->user_id]);
        }

        self::$_is[$this->user_id] = [];
        foreach ($this->UserList as $ul) {
            self::$_is[$this->user_id][] = $ul->usergroup_id;
        }

        return in_array($group->usergroup_id, self::$_is[$this->user_id]);
    }

    public function canDeleteBy(User $user): bool
    {

        //cannot delete myself
        if ($this->user_id == $user->user_id) {
            return false;
        }
        return parent::canDeleteBy($user);
    }
}
