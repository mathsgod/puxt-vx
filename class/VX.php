<?php

use Firebase\JWT\JWT;
use VX\UI\RTableResponse;
use PUXT\Context;
use Symfony\Component\Yaml\Yaml;
use VX\ACL;
use VX\EventLog;
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
use VX\UserLog;
use VX\UI;

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
    public $acl = [];
    public $ui;

    public function __construct()
    {
        $this->res = new Response;
        $this->ui = new UI($this);
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

        $this->user_id = 2;
        if ($jwt) {
            try {
                $data = (array)JWT::decode($jwt, $this->config["VX"]["jwt"]["secret"], ["HS256"]);
                $this->user_id = $data["user_id"];
                $this->logined = true;

                if ($view_as = $this->req->getHeader("vx-view-as")[0]) {
                    $this->view_as = $view_as;
                    $this->user_id = $view_as;
                }
            } catch (Exception $e) {
            }
        }
        $this->user = User::Query(["user_id" => $this->user_id])->first();

        $path = $context->route->path;
        $p = explode("/", $path)[0];
        $this->module = $this->loadModule($p);

        //load acl
        $this->loadACL();
    }

    private function loadACL()
    {
        $this->acl = [];
        $ugs = [];
        foreach ($this->user->UserGroup() as $ug) {
            $ugs[] = (string) $ug;
        }

        $acl = Yaml::parseFile(dirname(__DIR__) . DIRECTORY_SEPARATOR . "acl.yml");

        foreach ($acl["path"] as $path => $usergroups) {
            if (array_intersect($ugs, $usergroups)) {
                $this->acl["path"]["allow"][] = $path;
            }
        }

        foreach ($acl["action"] as $action => $actions) {
            foreach ($actions as $module => $usergroups) {
                if (array_intersect($ugs, $usergroups)) {
                    $this->acl["action"]["allow"][$module][] = $action;
                }
            }
        }

        $w = [];
        $u[] = "user_id=" . $this->user->user_id;
        foreach ($this->user->UserGroup() as $ug) {
            $u[] = "usergroup_id=$ug->usergroup_id";
        }
        $w[] = implode(" or ", $u);
        $query = ACL::Query()->where($w);
        foreach ($query as $acl) {
            if ($acl->action) {
                $this->acl["action"][$acl->value][$acl->module][] = $acl->action;
            } else {
                $this->acl["path"][$acl->value][] = $acl->path();
            }
        }

        //all special user
        foreach (ACL::Query()->where(["special_user is not null"]) as $acl) {
            $this->acl["special_user"][$acl->special_user][$acl->value][$acl->module][] = $acl->action;
        }
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


        if ($obj = $this->object()) {
            if ($obj->_id()) {
                $tab->setBaseURL($obj->uri(""));
            }
        }



        return $tab;
    }

    public function acl(string $path)
    {
        if ($path == "index" || $path == "logout") {
            return true;
        }

        return true;
    }

    public function createForm($data = null)
    {
        $form = new Form;
        if ($data) {
            $form->setData($data);
        } elseif ($obj = $this->object()) {
            $form->setData($obj);
        }
        return $form;
    }

    public function createRTable(string $entry)
    {
        $rt = new RTable();

        $query = $this->req->getQueryParams();
        $query["_entry"] = $entry;

        $remote = "/" . $this->route->path . "?" . http_build_query($query);

        $rt->setAttribute("remote", $remote);

        return $rt;
    }

    public function createRTableResponse()
    {
        return new RTableResponse($this, $this->query);
    }

    public function login(string $username, string $password): ?User
    {
        $ul = new UserLog();
        $ul->login_dt = date("Y-m-d H:i:s");
        $ul->ip = $_SERVER['REMOTE_ADDR'];
        $ul->user_agent = $_SERVER["HTTP_USER_AGENT"];

        try {
            $user = User::Login($username, $password);
            $ul->user_id = $user->user_id;
            $ul->result = "SUCCESS";
            $ul->save();
        } catch (Exception $e) {
            $ul = new UserLog();
            $ul->result = "FAIL";
            $ul->save();
            throw $e;
        }
        return $user;
    }

    public function logout()
    {
        $this->user_id = 2;
        //get last logout
        $o = UserLog::Query([
            "user_id" => $this->user_id
        ])->orderBy("userlog_id desc")->first();

        if ($o) {
            $o->logout_dt = date("Y-m-d H:i:s");
            $o->save();
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

        if (file_exists(dirname(__DIR__) . "/pages/$name")) {
            $config = [];
            if (file_exists($setting = dirname(__DIR__) . "/pages/$name/setting.yml")) {
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

        foreach (glob(dirname(__DIR__) . "/pages/*", GLOB_ONLYDIR) as $m) {
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

    public function trigger(string $name, $obj)
    {
        if ($name == "before_insert") {
            if (property_exists($obj, "created_by")) {
                $obj->created_by = $this->user_id;
            }
            return;
        }

        if ($name == "after_insert") {
            EventLog::LogInsert($obj, $this->user);
        }

        if ($name == "before_update") {
            if (property_exists($obj, "updated_by")) {
                $obj->created_by = $this->user_id;
            }

            EventLog::LogUpdate($obj, $this->user);
        }

        if ($name == "after_update") {
        }

        if ($name == "before_delete") {
            EventLog::LogDelete($obj, $this->user);
        }
    }
}
