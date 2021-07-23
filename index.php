<?php

use PUXT\App;
use Symfony\Component\Yaml\Parser;
use VX\Model;
use VX\Config;

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

        foreach (Config::Query() as $config) {
            $vx->config["VX"][$config->name] = $config->value;
        }

        $path = $puxt->context->route->path;
        $org_path = $puxt->context->route->path;

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

        $vx->request_uri = $path;
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

        $module = $vx->module;
        if (!$module->name) {
            $module = null;
        }

        //--- REST ---
        //create
        if (
            $vx->req->getMethod() == "POST"
            && strstr($vx->req->getHeader("Content-Type")[0], "application/json")
            && $module
            && !$vx->object_id
            && $module->name == $org_path
        ) {
            if (!$vx->logined) {
                http_response_code(401);
                exit();
            }

            $obj = $module->createObject();
            $obj->bind($vx->req->getParsedBody());
            $obj->save();
            $id = $obj->_id();

            header("Location: /$module->name/$id", true, 201);
            exit();
        }

        if (
            $vx->req->getMethod() == "PATCH"
            && strstr($vx->req->getHeader("Content-Type")[0], "application/json")
            && $vx->object_id
            && (($module->name . "/" . $vx->object_id) == $org_path)
        ) {
            if (!$vx->logined) {
                http_response_code(401);
                exit();
            }
            $body = $vx->req->getParsedBody();
            $obj = $module->getObject($vx->object_id);

            if (!$obj->canUpdateBy($vx->user)) {
                http_response_code(403);
                exit();
            }

            $obj->bind($body);
            $obj->save();

            http_response_code(204);
            exit();
        }

        if ($vx->req->getMethod() == "DELETE") {

            if (!$vx->logined) {
                http_response_code(401);
                exit();
            }

            if ($obj = $vx->object()) {
                if (!$obj->canDeleteBy($vx->user)) {
                    http_response_code(403);
                    exit();
                }
                $obj->delete();
                http_response_code(204);
            } else {
                http_response_code(404);
            }
            die();
        }

        //check permission
        if (!$vx->acl($path)) {

            if ($vx->logined) {
                http_response_code(403);
            } else {
                http_response_code(401);
            }
            exit();
        }

        $globs = glob("pages/" . $path . ".*");

        if (count($globs)) {
            return;
        }
        $this->puxt->config["dir"]["pages"] = "vendor/mathsgod/puxt-vx/pages";
    });

    $this->puxt->hook("render:before", function ($page) use ($vx) {
        $data = [];
        if (is_object($page->stub)) {
            $p = [];
        } else {
            $p = $page->stub["page"];
        }


        $basename = basename($page->context->route->path);
        if ($basename == "ae" && !$p) {
            if ($obj = $page->context->object()) {

                if ($obj->_id()) {
                    $p["header"] = ["title" => "Edit"];
                } else {
                    $p["header"] = ["title" => "Add"];
                }
            }
        }




        $content = $page->render("");

        if (!is_array($content) && $content) {
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
