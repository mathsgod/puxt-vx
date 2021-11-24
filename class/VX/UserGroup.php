<?php

namespace VX;

use Laminas\Db\Sql\Where;
use Laminas\Permissions\Acl\Role\RoleInterface;
use Symfony\Component\Validator\Constraints as Assert;

class UserGroup extends Model implements RoleInterface
{
    #[Assert\NotBlank]
    public $name;

    public function getRoleId()
    {
        return "ug-" . $this->usergroup_id;
    }

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
        $ug = self::Query([
            "name" => $name,
            "code" => $name
        ], "OR")->first();
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

    public function User()
    {
        return User::Query(function (Where $where) {
            $where->expression("user_id in (select user_id from UserList where usergroup_id=?)", $this->usergroup_id);
        });
    }
}
