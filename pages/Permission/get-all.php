<?php

/**
 * @author Raymond Chong
 * @date 2022-12-30 
 */
return new class
{
    function get(VX $vx)
    {

        $modules = $vx->getModules();

        $data = [];

        foreach ($modules as $module) {
            $data[] = $module->getPermission();
        }
        return $data;
    }
};
