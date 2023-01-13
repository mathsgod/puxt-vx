<?php

/**
 * @author Raymond Chong
 * @date 2023-01-13 
 */

use VX\Role;

return new class
{
    function get(VX $vx)
    {
        $data = [];
        $data[] = ["name" => "Administrators"];
        $data[] = ["name" => "Power Users"];
        $data[] = ["name" => "Users"];

        foreach (Role::Query()->toArray() as $role) {
            $data[] = [
                "name" => $role->name,
            ];
        }

        return $data;
    }
};
