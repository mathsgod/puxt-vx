<?php

use Symfony\Component\Yaml\Yaml;
use VX\Module;

return [
    "get" => function () {

        $data = [
            "logined" => false
        ];


        //load menus
        $modules = [];
        foreach (glob(__DIR__ . "/*", GLOB_ONLYDIR) as $m) {
            $name = basename($m);
            $config = [];
            if (is_readable($config_file = $m . DIRECTORY_SEPARATOR . "setting.yml")) {
                $config = Yaml::parseFile($config_file);
            }

            $modules[] = new Module($name, $config);
        }


        $menus = [];
        foreach ($modules as $m) {
            $menus[] = $m->getMenuItem();
        }

        $data["logined"]=true;
        $data["menus"] = $menus;
        return $data;






        //group menu to structure
        $g = function (&$gs, &$m) use (&$g) {
            if (is_array($gs)) {
                foreach ($gs as $k => &$v) {
                    if (is_array($v)) {
                        $g($v, $m);
                    } else {
                        $v[] = $m;
                    }
                }
            }
        };


        $ms = [];
        foreach ($modules as $module) {
            if ($module->hide)
                continue;
            if (is_array($module->group)) {
                $gs = $module->group;
                $g($gs, $module);
                $ms = array_merge_recursive($ms, $gs);
            } elseif ($module->group) {
                $ms[$module->group][] = $module;
            } else {
                $ms[] = $module;
            }
        }


        $menu_gen = function ($ms) use (&$menu_gen) {
            $sidebar_menu = [];
            foreach ($ms as $modulegroup_name => $modules) {
                if (is_array($modules)) {
                    if (!sizeof($modules)) {
                        continue;
                    }

                    $menu = new stdClass();
                    //$menu->label = $app->translate($modulegroup_name);
                    $menu->label = $modulegroup_name;
                    $menu->link = "#";
                    //$menu->icon = $app->setting['group'][$modulegroup_name]["icon"] ?? "far fa-circle";
                    $menu->icon = "far fa-circle";
                    $menu->keyword = $menu->label . " " . $modulegroup_name;
                    $menu->submenu = $menu_gen($modules);

                    if (!sizeof($menu->submenu)) {
                        continue;
                    }

                    $sidebar_menu[] = $menu;
                } else {
                    $module = $modules;
                    $links = [];


                    foreach ($module->getMenuLink() as $link) {

                        /*if ($this->app->acl($link->link)) {
                            if ($link->badge) {
                                //$p = $app->page($link->badge);
                                //$link->badge = $p->get();
                            }

                            $links[] = $link;
                        }*/
                        $links[] = $link;
                    }
                    if (!sizeof($links)) {
                        continue;
                    }
                    $menu = new stdClass();
                    $menu->label = $module->translate($module->name);
                    $menu->icon = $module->icon;
                    $menu->keyword = $module->keyword();


                    /*                    if ($module->badge) {
                        $p = $app->page($module->badge);
                        $menu["badge"] = $p->get();
                    }
*/

                    //$menu->active = $app->module->name == $module->name;

                    if (sizeof($links) > 1) {
                        $menu->link = "#";
                        $menu->submenu = $links;
                    } else {
                        $menu->link = $links[0]->link;
                        $menu->target = $links[0]->target;
                    }
                    $sidebar_menu[] = $menu;
                }
            }
            return $sidebar_menu;
        };

        $sidebar_menu = $menu_gen($ms);

        foreach ($sidebar_menu as $menu) {
            //     $menu->getBadge();
        }

        print_r($sidebar_menu);
        return ["menus" => $sidebar_menu];
    }
];
