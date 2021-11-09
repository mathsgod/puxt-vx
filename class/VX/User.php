<?php

namespace VX;

use Exception;
use Laminas\Db\Sql\Where;
use Laminas\Permissions\Acl\Role\RoleInterface;

/**
 * @property int $user_id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $username
 * @property array $style
 */
class User extends Model implements RoleInterface
{
    public static $_table = "User";

    static function Load(int $id): ?static
    {
        $user = parent::Load($id);
        if (!is_array($user->style)) {
            $user->style = json_decode($user->style,true);
        }
        return $user;
    }

    function save()
    {
        $attr = self::__attribute("style");
        if ($attr["Type"] != "json") {
            $this->style = json_encode($this->style, JSON_UNESCAPED_UNICODE);
        }
        return parent::save();
    }


    public function isSystemAccount()
    {
        return $this->user_id == 1 || $this->user_id == 2 || $this->user_id == 3;
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
        return $this->MyFavorite->where(["path" => $path])->delete();
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

    private static function PasswordVerify(string $password, string $hash)
    {
        $p = substr($hash, 0, 2);
        if ($p == '$5' || $p == '$6') {
            $pass = "";
            $md5 = md5($password);
            eval(base64_decode("JHBhc3MgPSBtZDUoc3Vic3RyKHN1YnN0cigkbWQ1LC0xNiksLTgpLnN1YnN0cihzdWJzdHIoJG1kNSwtMTYpLDAsLTgpLnN1YnN0cihzdWJzdHIoJG1kNSwwLC0xNiksLTgpLnN1YnN0cihzdWJzdHIoJG1kNSwwLC0xNiksMCwtOCkpOw=="));
            return crypt($pass, $hash) == $hash;
        } else {
            return password_verify($password, $hash);
        }
    }

    const STATUS = ["Active", "Inactive"];
    /**
     * loing with username and password, thow exception if fail
     */
    public static function Login(string $username, string $password):self
    {
        $user = self::Query([
            "username" => $username,
            "status" => 0
        ])->first();

        if (!$user) {
            throw new Exception("user not found");
        }

        //check password
        if (!self::PasswordVerify($password, $user->password)) {
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
            $photo = "data:image/png;base64,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";
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
