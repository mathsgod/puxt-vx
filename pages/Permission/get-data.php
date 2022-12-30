<?php

/**
 * @author Raymond Chong
 * @date 2022-12-30 
 */

use VX\Permission;

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
                    "disabled" => true
                ];
            }

            return $ds;
        }

        $data = [];
        foreach (Permission::Query(["role" => $vx->_get["role"]]) as $p) {
            $data[] = [
                "value" => $p->value,
            ];
        }
        return $data;
    }
};
