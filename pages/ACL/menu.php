<?php

/**
 * Created by: Raymond Chong
 * Date: 2022-07-21 
 */

use Laminas\Diactoros\Response\EmptyResponse;
use VX\ACL;

return new class
{

    function post(VX $vx)
    {

        if (!$vx->_post["usergroup_id"]) {
            return new EmptyResponse();
        }

        ACL::Query([
            "usergroup_id" => $vx->_post["usergroup_id"]
        ])->delete();


        foreach ($vx->_post["path"] as $path) {

            $path = substr($path, 1);

            $ss = explode("/", $path, 2);

            ACL::Create([
                "usergroup_id" => $vx->_post["usergroup_id"],
                "module" => $ss[0],
                "path" => $ss[1],
                "value" => "allow"
            ])->save();
        }

        return new EmptyResponse();
    }


    function get(VX $vx)
    {

        $modules = $vx->getModules();

        $data = [];
        foreach ($modules as $module) {
            if ($module->isHide()) continue;


            $data[] = [
                "label" => $module->name,
                "icon" => $module->icon,
                "menu" => $module->getMenus(),
                "link" => $module->getResourceId()

            ];
        }

        return $data;
    }

    function getMenus(VX $vx)
    {
        $path = [];
        foreach (ACL::Query([
            "usergroup_id" => $vx->_get["usergroup_id"]
        ]) as $acl) {

            $path[] = "/" . $acl->module . "/" . $acl->path;
        }

        return $path;
    }
};
