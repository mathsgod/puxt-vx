<?php

namespace VX;

use Laminas\Db\Sql\Where;
use Closure;
use Laminas\Permissions\Rbac\RoleInterface;
use Symfony\Component\Validator\Constraints as Assert;
use TheCodingMachine\GraphQLite\Annotations\Field;
use VX\Security\AssertionInterface;
use VX\Security\Security;
use VX\Security\UserInterface;
use VX\User\Favoriteable;
use Laminas\Db\Sql\Predicate;

/**
 * @property int $user_id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $username
 */
class User extends Model implements UserInterface, StyleableInterface, AssertionInterface, Favoriteable
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

    const STATUS = ["Active", "Inactive"];

    static function Query($predicate = null, $combination = Predicate\PredicateSet::OP_AND)
    {
        $q = parent::Query($predicate, $combination);

        //only administator can see administrator
        if (!self::$_vx->getCurrentUser()->is("Administrators")) {

            $q->where->notIn("user_id", array_column(UserRole::Query(["role" => "Administrators"])->columns(["user_id"])->toArray(), "user_id"));;
        }

        return $q;
    }


    function getFavorites()
    {
        $favs = [];
        foreach (MyFavorite::Query() as $fav) {
            $favs[] = [
                "id" => $fav->my_favorite_id,
                "icon" => $fav->icon ?? "link",
                "label" => $fav->label,
                "link" => $fav->path,
                "name" => $fav->label
            ];
        }
        return $favs;
    }

    function removeFavorite($id)
    {
        MyFavorite::Get($id)->delete();
    }

    function addFavorite(string $label, string $path, ?string $icon = null)
    {
        MyFavorite::Create([
            "user_id" => $this->user_id,
            "label" => $label,
            "path" => $path,
            "icon" => $icon
        ])->save();
    }

    function getStyles(): array
    {
        $default_style = [
            "dense" => true,
            "theme" => "semi-dark",
        ];

        $attr = self::__attribute("style");
        if ($attr["Type"] == "json") {
            return $this->style ?? $default_style;
        }
        return json_decode($this->style, true) ?? $default_style;
    }

    function setStyles(array $styles): void
    {
        $attr = self::__attribute("style");
        if ($attr["Type"] === "json") {
            $this->style = $styles;
        } else {
            $this->style = json_encode($styles, JSON_UNESCAPED_UNICODE);
        }
        $this->save();
    }

    function assert(Security $security, UserInterface $user, string $permission): bool
    {

        if ($permission === "list") {
            if ($user->is("Guests")) return false;
            if ($user->is("Users")) return false;
            if ($user->is("Power Users")) return true;
        }

        if ($permission === "update") {
            if ($this->is("Guests")) return false;
            if ($user->is("Guests")) return false;
            if ($user->is("Users")) {
                if ($this->user_id == $user->getIdentity()) return true;
                return false;
            }

            if ($user->is("Power Users")) {
                //except admin
                if ($this->is("Administrators")) return false;
                return true;
            }
        }

        if ($permission === "read") {
            if (in_array("Guests", $this->getRoles())) return false;

            if ($user->is("Users")) {
                if ($this->user_id == $user->getIdentity()) return true;
            }

            if ($user->is("Power Users")) {
                //except admin
                if ($this->is("Administrators")) return false;
                if ($this->is("Guests")) return false;
            }
        }


        if ($permission === "delete") {
            //no one can delete guest
            if ($this->is("Guests")) return false;

            //no one can delete self
            if ($this->user_id == $user->getIdentity()) return false;

            if ($user->is("Power Users")) {
                //except admin
                if ($this->is("Administrators")) return false;
                return true;
            }
        }

        if ($permission === "can_change_password") {
            if ($user->is("Guests")) return false;
            if ($this->user_id == $user->getIdentity()) return true;
            if ($user->is("Administrators")) return true;
            return false;
        }

        return parent::assert($security, $user, $permission);
    }

    function getIdentity(): string
    {
        return $this->user_id;
    }

    function delete()
    {
        UserRole::Query(["user_id" => $this->user_id])->delete();
        return parent::delete();
    }

    /*   public function getDetail(string $name, $default = null)
    {
    }

    public function getDetails(): array
    {
        return [];
    } */

    public function removeRole(string $role): void
    {
        UserRole::Query(["user_id" => $this->user_id, "role" => $role])->delete();
    }

    public function addRole(string $role): void
    {
        if ($this->is($role)) return;
        UserRole::Create(["user_id" => $this->user_id, "role" => $role])->save();
    }

    #[Field]
    public function getRoles(): array
    {
        $roles = [];
        foreach (UserRole::Query(["user_id" => $this->user_id]) as $ur) {
            $roles[] = $ur->role;
        }

        if (count($roles) == 0) {
            $roles[] = "Everyone";
        }

        return $roles;
    }

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
        $name = $this->first_name;
        if ($this->last_name) {
            $name .= " " . $this->last_name;
        }
        return $name;
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

    public function need2Step(string $remote_ip)
    {
        if (!$this->secret) return false;

        $whitelist = $this->two_step["whitelist"] ?? [];

        if (in_array($remote_ip, $whitelist)) {
            return false;
        }

        return true;
    }

    public function is(RoleInterface|string $role): bool
    {
        if ($role instanceof RoleInterface) {
            $name = $role->getName();
        } else {
            $name = $role;
        }


        return in_array($name, $this->getAllRoles());
    }


    private function getRoleChild(string $role): array
    {
        $roles = [];
        $security = self::$_vx->getSecurity();
        foreach ($security->getRole($role)->getChildren() as $child) {
            $roles[] = $child->getName();

            foreach ($this->getRoleChild($child->getName()) as $c) {
                $roles[] = $c;
            }
        }

        return $roles;
    }
    public function getAllRoles()
    {
        $roles = [];
        foreach ($this->getRoles() as $role) {
            $roles[] = $role;
            foreach ($this->getRoleChild($role) as $c) {
                $roles[] = $c;
            }
        }
        return $roles;
    }

    public function __toString()
    {
        return $this->first_name . " " . $this->last_name;
    }

    public function toArray(?array $fields = []): array
    {
        $arr = parent::toArray($fields);
        //remove password
        unset($arr["password"]);
        return $arr;
    }
}
