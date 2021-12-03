<?php

/**
 * Created by: Raymond Chong
 * Date: 2021-07-22 
 */

use Psr\Http\Message\ResponseInterface;
use VX\Translate;

return new class
{
    function post(VX $vx)
    {
        //delete all 
        Translate::Query(["module" => $vx->_post["module"]])->delete();

        foreach ($vx->_post["items"] as $item) {
            foreach ($item["value"] as $v) {

                $t = new Translate();
                $t->module = $vx->_post["module"];
                $t->name = $item["name"];
                $t->language = $v["language"];
                $t->value = $v["value"];
                $t->save();
            }
        }
    }

    function getData(VX $vx)
    {
        $modules = [];
        foreach ($vx->getModules() as $module) {
            $modules[] = ["name" => $module->name];
        }
        return ["modules" => $modules, "languages" => array_keys($vx->config["VX"]["language"])];
    }

    function getTranslate(VX $vx)
    {
        $data = [];
        foreach (Translate::Query(["module" => $vx->_get["module"]]) as $t) {
            $d = $data[$t->name];
            if (!$d) {
                $d = [
                    "name" => $t->name,
                    "value" => []
                ];
            }

            $d["value"][] = ["language" => $t->language, "value" => $t->value];

            $data[$t->name] = $d;
        }

        return array_values($data);
    }
};
