<?php

use VX\UI\RTableResponse;
use PUXT\Context;
use Symfony\Component\Yaml\Yaml;
use VX\IModel;
use VX\Module;
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
    public function __construct(Context $context)
    {
        foreach ($context as $k => $v) {
            $this->$k = $v;
        }

        if (!$_SESSION["VX"]) $_SESSION["VX"] = ["user_id" => 2];

        $this->user_id = $_SESSION["VX"]["user_id"];
        $this->user = User::Query(["user_id" => $this->user_id])->first();

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

    public function logined()
    {
        return $_SESSION["VX"]["user_id"] != 2;
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

    public function login(string $username, string $password)
    {
        try {
            $user = User::Login($username, $password);
            $_SESSION["VX"]["user_id"] = $user->user_id;
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
        return new View();
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
}
