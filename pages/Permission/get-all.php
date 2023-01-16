<?php

/**
 * @author Raymond Chong
 * @date 2022-12-30 
 */

use VX\Permission;

return new class
{
    private $permission = [];
    private $role = "";

    /**
     * @var \VX\Security\Security
     */
    private $preset_security = null;

    private function setAllValue(&$d)
    {
        if ($this->preset_security->getRbac()->isGranted($this->role, $d["value"]??"")) {
            $d["disabled"] = true;
        }

        if ($this->role == "Administrators") {
            $d["disabled"] = true;
        }

        foreach ($d["children"] as &$value) {
            $this->setAllValue($value);
        }
    }

    function get(VX $vx)
    {
        $role = $vx->_get["role"];
        $this->role = $role;
        $this->preset_security = $vx->getPresetSecurity();

        foreach (Permission::Query(["role" => $vx->_get["role"]]) as $p) {
            $this->permission[] = $p->value;
        }


        $modules = $vx->getModules();

        $data = [];

        foreach ($modules as $module) {
            $data[] = $module->getPermission();
        }

        if ($this->role) {
            foreach ($data as &$d) {
                $this->setAllValue($d);
            }
        }



        return $data;
    }
};
