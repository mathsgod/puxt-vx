<?php

use VX\Module;
use VX\ModuleGroup;

class Menu
{
    public $items = [];
    public $groups = [];
    public function addModule(Module $module)
    {
        if ($module->group) {
            if (!$mg = $this->groups[$module->group]) {
                $mg = new ModuleGroup($module->group);
                $this->groups[$module->group] = $mg;
                $this->items[] = $mg;
            }
            $mg->add($module);
        } else {
            $this->items[] = $module;
        }
    }


    public function getMenu()
    {
        $data = [];
        foreach ($this->items as $item) {
            $data[] = $item->getMenuItem();
        }
        return $data;
    }
}

return [
    "post" => function (VX $context) {
        $body = $context->req->getParsedBody();

        switch ($body["action"]) {
            case "selectedLanguage":
                $user = $context->user;
                $user->language = $body["data"];
                $user->save();
                break;
            case "color":
                $user = $context->user;
                $user->style["color"] = $body["data"];
                $user->save();
                break;
        }
        return ["code" => 200];
    },
    "get" => function (VX $context) {

        $logined = $context->logined;
        $data = [
            "logined" => $logined
        ];

        if ($logined) {
            $modules = $context->getModules();

            $menu = new Menu();
            foreach ($modules as $m) {
                $menu->addModule($m);
            }

            $data["menus"] = $menu->getMenu();

            //language 
            $data["language"] = $context->config["VX"]["language"];

            //user
            $user = $context->user;
            $data["me"] = [
                "first_name" => $user->first_name,
                "last_name" => $user->last_name,
                "language" => $user->language ?? "en",
                "style" => $user->style
            ];
        }

        $config = $context->config["VX"];
        $data["config"] = [
            "company" => $config["company"],
            "copyright-year" => $config["copyright-year"],
            "copyright-url" => $config["copyright-url"],
            "copyright-name" => $config["copyright-name"]
        ];


        return $data;
    }
];
