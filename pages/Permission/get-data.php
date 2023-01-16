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
    function get(VX $vx)
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

        //preset permission

        $preset_security = $vx->getPresetSecurity();
        $preset = array_merge(...array_values($vx->getPresetPermissions()));
        foreach ($preset as $value) {
            if ($preset_security->getRbac()->isGranted($vx->_get["role"], $value)) {
                $data[] = [
                    "value" => $value,
                ];
            }
        }


        foreach (Permission::Query(["role" => $vx->_get["role"]]) as $p) {
            if (in_array($p->value, $preset)) continue;
            $data[] = [
                "value" => $p->value,
            ];
        }
        return $data;
    }
};
