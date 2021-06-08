<?php

use Firebase\JWT\JWT;
use VX\UI\RTableResponse;
use PUXT\Context;
use Symfony\Component\Yaml\Yaml;
use VX\IModel;
use VX\Module;
use VX\Response;
use VX\UI\Form;
use VX\UI\FormItem;
use VX\UI\FormTable;
use VX\UI\RTable;
use VX\UI\Tabs;
use VX\User;
use VX\UI\View;

/**
 * @property User $user
 * @property int $user_id
 * @property Module $module
 */
class VX extends Context
{

    public $user;
    public $user_id;
    public $module;
    public $logined = false;
    public $res;

    public function __construct()
    {
        $this->res = new Response;
    }

    public function init(Context $context)
    {
        foreach ($context as $k => $v) {
            $this->$k = $v;
        }

        //        $auth = $context->req->getHeader("Authorization");

        $token = $this->req->getHeader("Authorization")[0];
        if ($token) {
            $jwt = explode("Bearer ", $token)[1];
        }

        if ($this->req->getQueryParams()["_token"]) {
            $jwt = $this->req->getQueryParams()["_token"];
        }

        if ($jwt) {

            $this->user_id = 2;
            try {
                $data = (array)JWT::decode($jwt, $this->config["VX"]["jwt"]["secret"], ["HS256"]);
                $this->user_id = $data["user_id"];
                $this->logined = true;
            } catch (Exception $e) {
            }
            $this->user = User::Query(["user_id" => $this->user_id])->first();
        }

        $path = $context->route->path;
        $p = explode("/", $path)[0];
        $this->module = $this->loadModule($p);
    }


    public function createFormTable($data, string $data_key, string $data_name = "data")
    {
        $t = new FormTable;
        $t->setAttribute("data-key", $data_key);
        $t->setAttribute("data-name", $data_name);

        if ($data) {
            $t->setAttribute(":data", json_encode($data));
        }
        return $t;
    }

    public function createTab()
    {
        $tab = new Tabs;

        $tab->setBaseURL(dirname($this->req->getUri()->getPath()));

        return $tab;
    }

    public function acl(string $path)
    {
        if ($path == "index" || $path == "logout") {
            return true;
        }

        return true;
    }

    public function createForm()
    {
        $form = new Form;
        if ($obj = $this->object()) {
            $form->setData($obj);
        }
        return $form;
    }

    public function createRTable(string $entry)
    {
        $rt = new RTable();

        $uri = $this->req->getUri();

        $query = $this->req->getQueryParams();
        $query["_entry"] = $entry;

        $uri = $uri->withQuery(http_build_query($query));

        $rt->setAttribute("remote", $uri->getPath() . "?" . $uri->getQuery());

        return $rt;
    }

    public function createRTableResponse()
    {
        return new RTableResponse($this, $this->query);
    }

    public function login(string $username, string $password): ?User
    {
        try {
            return User::Login($username, $password);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function object(): ?IModel
    {
        if ($this->module) {
            $class = $this->module->class;

            if (class_exists($class, true)) {
                return new $class($this->object_id);
            }
        }
    }

    public function loadModule(string $name)
    {
        if (file_exists($this->root . "/pages/$name")) {
            $config = [];
            if (file_exists($setting = $this->root . "/pages/$name/setting.yml")) {
                $config = Yaml::parseFile($setting);
            }

            return new Module($name, $config);
        }
    }

    public function createView()
    {
        $view = new View();
        $view->setData($this->object());


        return $view;
    }

    public function getModules()
    {

        $modules = [];
        foreach (glob($this->root . "/pages/*", GLOB_ONLYDIR) as $m) {
            $name = basename($m);
            $module = new Module($name);
            $module->loadConfigFile($m . "/setting.yml");
            $modules[] = $module;
        }

        return $modules;
    }

    public function postForm()
    {
        $body = $this->req->getParsedBody();
        if ($obj = $this->object()) {
            $obj->bind($body);
            $obj->save();
        }
        return $obj;
    }
}
