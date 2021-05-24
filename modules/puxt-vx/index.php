<?php

use PUXT\App;
use VX\Model;

return function ($options) {

    $this->puxt->hook('ready', function (App $puxt) {

        Model::$db = $puxt->context->db;

        $vx = $puxt->context = new VX($puxt->context);
        $vx->db = Model::$db;

        $path = $puxt->context->route->path;

        if ($path == "") {
            $path = "index";
        }

        if (substr($path, -1) == "/") {
            $path .= "index";
        }

        // skip id
        $t = [];
        $id = null;

        foreach (explode("/", $path) as $q) {
            if (is_numeric($q)) {
                $ids[] = $q;
                if (!$id) {
                    $id = $q;
                }
                continue;
            }
            $t[] = $q;
        }
        $path = implode("/", $t);
        $puxt->context->route->path = $path;

        $globs = glob("pages/" . $path . ".*");

        if (count($globs)) {
            return;
        }

        //$this->puxt->config["dir"]["pages"] = "modules/puxt-vx/pages";
    });

    $this->puxt->hook("render:before", function ($page) {



        $type = $page->stub["type"];

        $content = $page->render("");
        if ($type == "page") {
            header("Content-type: application/json; charset=utf-8");
            $data = [
                "data" => [
                    "content" => $content
                ]
            ];

            echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            exit();
        }
    });
};
