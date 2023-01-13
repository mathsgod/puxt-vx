<?php

/**
 * @author Raymond Chong
 * @date 2022-12-30 
 */

use Laminas\Permissions\Rbac\RoleInterface;
use VX\Security\Security;

return new class
{
    private function findChildren(RoleInterface $role)
    {
        $data = [];
        foreach ($role->getParents() as $p) {
            $data[] = [
                "label" => $p->getName(),
                "name" => $p->getName(),
                "parent" => $role->getName(),
                "children" => $this->findChildren($p),
            ];
        }
        return $data;
    }

    function get(VX $vx, Security $security)
    {
        $everyone = $security->getRole("Everyone");
        foreach ($everyone->getParents() as $parent) {
            $name = $parent->getName();
            if ($name == "Administrators" || $name == "Power Users" || $name == "Users" || $name == "Guests") {
                $readonly = true;
            }else{
                $readonly = false;
            }
            $data[] = [
                "label" => $parent->getName(),
                "name" => $parent->getName(),
                "parent" => "Everyone",
                "children" => $this->findChildren($parent),
                "readonly" => $readonly,
            ];
        }

        return [
            [
                "label" => "Everyone",
                "name" => "Everyone",
                "readonly" => true,
                "children" => $data
            ]
        ];
    }
};
