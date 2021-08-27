<?php

namespace VX;

use Exception;
use Laminas\Db\Sql\Where;
use Laminas\Permissions\Acl\Role\RoleInterface;

class User extends Model implements RoleInterface
{

    public function isSystemAccount()
    {
        return $this->user_id == 1 || $this->user_id == 2;
    }


    public function getRoleId()
    {
        return "u-" . $this->user_id;
    }

    public function need2Step(string $remote_ip)
    {
        if (!$this->secret) return false;

        $whitelist = $this->two_step["whitelist"] ?? [];

        if (in_array($remote_ip, $whitelist)) {
            return false;
        }

        return true;
    }

    public function removeMyFavorite(string $path)
    {
        return $this->MyFavorite->filter(["path" => $path])->delete()->execute();
    }

    public function addMyFavorite(string $label, string $path)
    {

        $fav = new MyFavorite;
        $fav->user_id = $this->user_id;
        $fav->label = $label;
        $fav->path = $path;
        $fav->save();

        return $fav;
    }


    public function canChangePasswordBy(User $user)
    {
        if ($this->user_id == $user->user_id) {
            return true;
        }

        if ($user->isAdmin()) {
            return true;
        }

        if ($this->isAdmin()) {
            return false;
        }

        if ($user->isPowerUser()) {
            return true;
        }

        return false;
    }

    const STATUS = ["Active", "Inactive"];
    public static function Login(string $username, string $password)
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

    public function photo()
    {
        if ($this->photo) {
            $photo = "data:image/png;base64," . base64_encode($this->photo);
        } else {
            $photo = "images/user.png";
        }

        return $photo;
    }

    public function isAdmin(): bool
    {
        return $this->is("Administrators");
    }

    public function isPowerUser(): bool
    {
        return $this->is("Power Users");
    }

    public function isUser(): bool
    {
        return $this->is("Users");
    }

    public function isGuest(): bool
    {
        return $this->is("Guests");
    }

    public function canDeleteBy(User $user): bool
    {
        if ($this->isSystemAccount()) return false;
        if ($user->user_id == $this->user_id) return false; //no one can delete self

        if ($user->isAdmin()) return true; //admin can delete all
        if ($this->isGuest()) return false; //cannot delete guest
        if ($this->isAdmin()) return false; //no one can edit admin

        if ($user->isPowerUser()) return true; //power user can delete other

        return false;
    }

    public function canUpdateBy(User $user): bool
    {
        if ($user->isAdmin()) return true; //admin can update all
        if ($user->user_id == $this->user_id) return true; //update self

        if ($this->isAdmin()) return false; //no one can edit admin
        if ($this->isGuest()) return false; //cannot udpate guest

        if ($user->isPowerUser()) return true; //power user can edit other

        return false;
    }

    public function canReadBy(User $user): bool
    {
        if ($user->user_id == $this->user_id) return true; //anyone can read self
        if ($user->isAdmin()) return true; //admin can read all
        if ($this->isGuest()) return false; //cannot read guest
        if ($this->isAdmin()) return false; //no one can read admin

        return parent::canReadBy($user);
    }

    public function UserGroup()
    {
        return UserGroup::Query()
            ->where(fn (Where $where) => $where->expression("usergroup_id in (select usergroup_id from UserList where user_id=?)", [$this->user_id]));
    }
}
