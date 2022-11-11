<?php

namespace VX;

use Exception;
use Laminas\Db\Sql\Where;
use Laminas\Permissions\Acl\Role\RoleInterface;
use Symfony\Component\Validator\Constraints as Assert;
use TheCodingMachine\GraphQLite\Annotations\Field;

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

    #[Assert\NotBlank]
    public $username;

    #[Assert\NotBlank]
    public $first_name;

    #[Assert\NotBlank]
    public $email;

    #[Assert\NotBlank]
    public $join_date;

    #[Assert\Choice([0, 1])]
    public $status;


    #[Field]
    function name()
    {
        return $this->first_name . " " . $this->last_name;
    }

    #[Field]
    function getStatus()
    {
        return $this->status == 0 ? "Active" : "Inactive";
    }

    static function Load($id): static
    {
        $user = parent::Load($id);
        if (!is_array($user->style)) {
            $user->style = json_decode($user->style, true);
        }
        return $user;
    }


    function getAddress()
    {
        $str = [];
        if ($this->addr1) {
            $str[] = $this->addr1;
        }
        if ($this->addr2) {
            $str[] = $this->addr2;
        }
        if ($this->addr3) {
            $str[] = $this->addr3;
        }
        return implode("\n", $str);
    }

    function getName(): string
    {
        return $this->first_name . " " . $this->last_name;
    }

    #[Field]
    function initial()
    {
        return $this->getInitial();
    }

    function getInitial(): string
    {
        $initial = "";
        if ($this->first_name) {
            $initial .= substr($this->first_name, 0, 1);
        }
        if ($this->last_name) {
            $initial .= substr($this->last_name, 0, 1);
        }
        return strtoupper($initial);
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
        if ($this->isGuest()) {
            return false;
        }

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
        return password_verify($password, $hash);
    }

    const STATUS = ["Active", "Inactive"];
    /**
     * loing with username and password, thow exception if fail
     */
    public static function Login(string $username, string $password): self
    {

        $user = self::Get([
            "username" => $username,
            "status" => 0
        ]);

        if (!$user) {
            throw new Exception("User not found or incorrect password", 400);
        }

        //check password
        if (!self::PasswordVerify($password, $user->password)) {
            throw new Exception("User not found or incorrect password", 400);
        }

        if ($user->expiry_date && strtotime($user->expiry_date) < time()) {
            throw new Exception("User account expired", 400);
        }

        if ($user->UserList->count() == 0) {
            throw new Exception("User has no user group", 400);
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
