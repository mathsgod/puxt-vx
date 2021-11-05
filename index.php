<?php

use PUXT\App;
use R\DB\Schema;
use Symfony\Component\Yaml\Parser;
use VX\Model;
use VX\Config;
use VX\EventLog;
use VX\TwigI18n;

return function ($options) {

    if ($_SERVER["REQUEST_METHOD"] == "OPTIONS") {
        header("HTTP/1.1 200 OK");
        exit();
    }

    $db_config = $this->puxt->config["database"];
    $schema = new Schema($db_config["database"], $db_config["hostname"], $db_config["username"], $db_config["password"]);

    $vx = new VX();
    $vx->setDbAdapter($schema->getDbAdatpter());
    Model::SetSchema($schema);

    $this->puxt->hook('ready', function (App $puxt) use ($vx, $schema) {
        $puxt->response = $puxt->response
            ->withHeader("Access-Control-Allow-Credentials", "true")
            ->withHeader("Access-Control-Allow-Headers", "Content-Type, Authorization, vx-view-as, rest-jwt")
            ->withHeader("Access-Control-Allow-Methods", "GET, POST, OPTIONS, PUT, PATCH, HEAD, DELETE")
            ->withHeader("Access-Control-Expose-Headers", "location, Content-Location");

        if ($_SERVER["HTTP_ORIGIN"]) {
            $puxt->response = $puxt->response->withHeader("Access-Control-Allow-Origin", $_SERVER["HTTP_ORIGIN"]);
        }

        Model::$_vx = $vx;

        $vx->init($puxt->context);

        $i18n = new TwigI18n;
        $i18n->setTranslator($vx->getTranslator());
        $puxt->addExtension($i18n);


        $puxt->context = $vx;

        $vx->db = $schema;


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
            if (is_dir("pages" . DIRECTORY_SEPARATOR . $path) || is_dir(__DIR__ . DIRECTORY_SEPARATOR . "pages" . DIRECTORY_SEPARATOR . $path)) {
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
        //get
        if (
            $vx->req->getMethod() == "GET"
            && $module
            && $vx->object_id
            && (($module->name . "/" . $vx->object_id) == $org_path)
        ) {

            $obj = $module->getObject($vx->object_id);

            if (!$obj->canReadBy($vx->user)) {
                http_response_code(403);
                die();
            }


            header("Content-Type: application/json");
            header("Content-Location: " . $obj->uri());
            echo json_encode($obj, JSON_UNESCAPED_UNICODE);
            exit();
        }


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

            try {

                $obj = $module->createObject();
                $obj->bind($vx->req->getParsedBody());
                $obj->save();
                $id = $obj->_id();
                http_response_code(201);
                header("Content-Location: " . $obj->uri());
                exit();
            } catch (Exception $e) {

                $result = ["error" => [
                    "message" => $e->getMessage()
                ]];

                header("Content-Type: application/json");
                echo json_encode($result, JSON_UNESCAPED_UNICODE);
                exit();
            }
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
            $obj = $module->getObject($vx->object_id);

            if (!$obj->canUpdateBy($vx->user)) {
                http_response_code(403);
                exit();
            }

            $obj->bind($vx->req->getParsedBody());
            $obj->save();

            header("Content-Location: " . $obj->uri());
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

        try {
            //check permission
            if (!$vx->getAcl()->isAllowed($vx->user, $path)) {

                if ($vx->logined) {
                    http_response_code(403);
                } else {
                    http_response_code(401);
                }
                exit();
            }
        } catch (Exception $e) {

            $puxt->response = $puxt->response->withStatus(404, $e->getMessage());
            return;
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

        if (strstr($vx->req->getHeaderLine("accept"), "*/*") && $content) {
            echo $content;
            die();
        }


        /*         if (!is_array($content) && $content) {
            $data["type"] = "page";

            $p["content"] = $content;
            $data["body"] = $p;
        }

        if ($data) {
            header("Content-type: application/json; charset=utf-8");
            echo json_encode([$data], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            exit();
        }
 */
    });
};
