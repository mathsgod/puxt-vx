<?php

namespace VX;

use Exception;
use Symfony\Component\Yaml\Yaml;

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

        //cannot delete myself
        if ($this->user_id == $user->user_id) {
            return false;
        }
        return parent::canDeleteBy($user);
    }

    public function UserGroup()
    {
        return UserGroup::Query()->where("usergroup_id in (select usergroup_id from UserList where user_id=:user_id)", ["user_id" => $this->user_id]);
    }

    public function allow_uri(string $uri)
    {
        if ($this->isAdmin()) return true;
        $acl = $this->getACL();
        if (in_array($uri, $acl["path"]["allow"])) {
            return true;
        }

        $module = explode("/", $uri)[0];
        if (in_array("FC", $acl["action"]["allow"][$module] ?? [])) {
            return true;
        }
        return false;
    }

    public function getACL(): array
    {
        if ($this->_acl) return $this->_acl;
        $acl = [];
        $ugs = [];
        foreach ($this->UserGroup() as $ug) {
            $ugs[] = (string) $ug;
        }

        $acl_data = Yaml::parseFile(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "acl.yml");

        foreach ($acl_data["path"] as $path => $usergroups) {
            if (array_intersect($ugs, $usergroups)) {
                $acl["path"]["allow"][] = $path;
            }
        }

        foreach ($acl_data["action"] as $action => $actions) {
            foreach ($actions as $module => $usergroups) {
                if (array_intersect($ugs, $usergroups)) {
                    $acl["action"]["allow"][$module][] = $action;
                }
            }
        }

        $w = [];
        $u[] = "user_id=" . $this->user_id;
        foreach ($this->UserGroup() as $ug) {
            $u[] = "usergroup_id=$ug->usergroup_id";
        }
        $w[] = implode(" or ", $u);
        $query = ACL::Query()->where($w);
        foreach ($query as $a) {
            if ($a->action) {
                $acl["action"][$a->value][$a->module][] = $a->action;
            } else {
                $acl["path"][$a->value][] = $a->path();
            }
        }

        //all special user
        foreach (ACL::Query()->where(["special_user is not null"]) as $acl) {
            $acl["special_user"][$a->special_user][$a->value][$a->module][] = $acl->action;
        }

        $this->_acl = $acl;
        return $acl;
    }
}
