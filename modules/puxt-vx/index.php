<?php

use PUXT\App;
use Symfony\Component\Yaml\Parser;
use VX\Model;

return function ($options) {
    session_start();

    $this->puxt->hook('ready', function (App $puxt) {

        Model::$db = $puxt->context->db;

        $vx = $puxt->context = new VX($puxt->context);
        $vx->db = Model::$db;


        $parser = new Parser();
        $vx->config["VX"] = $parser->parseFile(__DIR__ . "/default.config.yml");


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

        $vx->object_id = $id;

        $path = implode("/", $t);
        $puxt->context->route->path = $path;

        //check permission
        if (!$vx->acl($path)) {
            header("Content-type: application/json; charset=utf-8");
            echo json_encode(["error" => [
                "code" => 401,
                "message" => "access deny"
            ]]);
            die();
        }


        $globs = glob("pages/" . $path . ".*");

        if (count($globs)) {
            return;
        }

        //$this->puxt->config["dir"]["pages"] = "modules/puxt-vx/pages";

        if ($vx->req->getMethod() == "DELETE") {

            if ($obj = $vx->object()) {
                if ($obj->canDeleteBy($vx->user)) {
                    $obj->delete();
                }
                echo json_encode(["code" => 200]);
                die();
            }
        }
    });

    $this->puxt->hook("render:before", function ($page) {

        $data = [];

        $p = $page->stub["page"];
        if ($p) {
            $data = $p;
        }


        $content = $page->render("");

        if ($p) {
            header("Content-type: application/json; charset=utf-8");
            $data["body"] = $content;
            echo json_encode(["data" => $data], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            exit();
        }
    });
};
