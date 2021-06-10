<?php

use PUXT\App;
use Symfony\Component\Yaml\Parser;
use VX\Model;

return function ($options) {

    $vx = new VX();

    $this->puxt->hook('ready', function (App $puxt) use ($vx) {

        Model::$_vx = $vx;

        Model::$db = $puxt->context->db;

        $vx->init($puxt->context);
        $puxt->context = $vx;

        $vx->db = Model::$db;


        $parser = new Parser();
        foreach ($parser->parseFile(__DIR__ . "/default.config.yml") as $k => $v) {
            $vx->config["VX"][$k] = $v;
        }

        $path = $puxt->context->route->path;


        if ($path == "") {
            $path = "index";
        }

        if (substr($path, -1) == "/") {
            $path .= "index";
        } else {
            if (is_dir("pages/" . $path)) {
                $path .= "/index";
            }
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


        $this->puxt->config["dir"]["pages"] = "vendor/mathsgod/puxt-vx/pages";
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

    $this->puxt->hook("render:before", function ($page) use ($vx) {

        $data = [];


        $p = $page->stub["page"];
        $content = $page->render("");

        if (!is_array($content)) {
            $data["type"] = "page";

            $p["content"] = $content;
            $data["body"] = $p;
        }


        if ($data) {
            header("Content-type: application/json; charset=utf-8");
            echo json_encode([$data], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            exit();
        }
    });
};
