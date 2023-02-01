<?php

/**
 * @author Raymond Chong
 * @date 2022-12-30 
 */

use VX\Permission;
use VX\Security\Security;

return new class
{
    private $permission = [];
    private $role = "";
    private $preset_permission = [];
    private $childrens = [];
    private $security;

    private function setAllValue(&$d)
    {
        if ($this->role == "Administrators") {
            $d["disabled"] = true;
        }

        if (in_array($d["value"], $this->preset_permission)) {
            $d["disabled"] = true;
        }

        foreach ($this->childrens as $c) {
            if ($this->security->getRbac()->isGranted($c, $d["value"] ?? "")) {
                $d["disabled"] = true;
            }
        }



        foreach ($d["children"] as &$value) {
            $this->setAllValue($value);
        }
    }

    function get(VX $vx, Security $security)
    {
        $role = $vx->_get["role"];
        $this->security = $security;

        $this->role = $role;
        $this->preset_permission = $vx->getPresetPermissions()[$this->role] ?? [];


        if ($this->role) {
            $this->childrens = $security->getRole($this->role)->getChildren();

            foreach (Permission::Query(["role" => $this->role]) as $p) {
                $this->permission[] = $p->value;
            }
        }


        $modules = $vx->getModules();

        $data = [];

        foreach ($modules as $module) {
            $d = $module->getPermission();
            $data[] = $d;
        }

        if ($this->role) {
            foreach ($data as &$d) {
                $this->setAllValue($d);
            }
        }



        return $data;
    }
};
