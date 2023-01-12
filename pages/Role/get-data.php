<?php

/**
 * @author Raymond Chong
 * @date 2022-12-30 
 */

use VX\Role;

return new class
{
    private function findChildren(Role $role)
    {
        $data = [];

        $children = $role->getChildren();

        foreach ($children as $role) {
            $data[] = [
                "role_id" => $role->role_id,
                "label" => $role->name,
                "name" => $role->name,
                "readonly" => $role->readonly,
                "children" => $this->findChildren($role)
            ];
        }
        return $data;
    }

    function get(VX $vx)
    {
        $roles = Role::Query(["parent_id" => null])->toArray();

        $data = [];

        foreach ($roles as $role) {

            if ($vx->user->is("Power Users") && $role->name == "Administrators") continue;
            


            $data[] = [
                "role_id" => $role->role_id,
                "label" => $role->name,
                "name" => $role->name,
                "readonly" => $role->readonly,
                "children" => $this->findChildren($role)
            ];
        }
        return $data;
    }
};
