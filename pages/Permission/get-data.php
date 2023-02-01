<?php

/**
 * @author Raymond Chong
 * @date 2022-12-30 
 */

use VX\Permission;
use VX\Security\Security;

return new class
{
    private function getAllValue($data)
    {
        $result = [];

        $result[] = $data["value"];

        foreach ($data["children"] as $value) {
            if (is_array($value)) {
                $result = array_merge($result, $this->getAllValue($value));
            } else {
                $result[] = $value;
            }
        }
        return $result;
    }
    function get(VX $vx, Security $security)
    {

        $data = [];
        if ($vx->_get["role"] == "Administrators") {
            $modules = $vx->getModules();
            $data = [];
            foreach ($modules as $module) {
                $data = array_merge($data, $this->getAllValue($module->getPermission()));
            }

            $data = array_unique($data);
            //remove empty string
            $data = array_filter($data);
            $ds = [];
            foreach ($data as $key => $value) {
                $ds[] = [
                    "value" => $value,
                ];
            }
            return $ds;
        }

        //all permission
        $permissions = [];
        foreach (Permission::Query()->toArray() as $p) {
            $permissions[] = $p->value;
        }

        $preset = array_merge(...array_values($vx->getPresetPermissions()));
        $permissions = array_values(array_merge($permissions, $preset));

        foreach ($permissions as $value) {
            if ($security->getRbac()->isGranted($vx->_get["role"], $value)) {
                $data[] = [
                    "value" => $value,
                ];
            }
        }

        return $data;
    }
};
