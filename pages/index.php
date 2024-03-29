<?php

use Laminas\Di\InjectorInterface;
use Symfony\Component\Yaml\Yaml;
use VX\FileManager;
use VX\Menu;
use VX\Security\Security;
use VX\StyleableInterface;

use VX\User;
use VX\User\Favoriteable;

return new class
{
    function get(VX $vx, InjectorInterface $injector, Security $security)
    {
        $logined = $vx->logined;
        $data = [
            "logined" => $logined,
            "locale" => "en"
        ];

        if ($logined) {
            //fav
            $data["favs"] = [];
            if ($vx->user instanceof Favoriteable) {
                $data["favs"] = $vx->user->getFavorites();
            }

            $page_setting = Yaml::parseFile(__DIR__ . "/setting.yml");


            if (file_exists($setting_file = $vx->root . DIRECTORY_SEPARATOR . "pages" . DIRECTORY_SEPARATOR . "setting.yml")) {
                $setting = Yaml::parseFile($setting_file);
                foreach ($setting["group"] as $name => $value) {
                    $page_setting["group"][$name] = $value;
                }
            }

            $group_icons = [];
            foreach ($page_setting["group"] as $name => $group) {
                $group_icons[$name] = $group["icon"];
            }


            $modules = $vx->getModules();


            /**
             * @var Menu $menu
             */
            $menu = $injector->create(Menu::class);
            $menu->setGroupIcon($group_icons);

            foreach ($modules as $m) {
                if ($m->name == "FileManager") {
                    if (!$vx->config["VX"]["file_manager_show"]) {
                        continue;
                    }
                }
                $menu->addModule($m);
            }

            $data["menus"] = $menu->getMenuByUser($vx->user);

            //language 
            $data["language"] = [];
            foreach ($vx->languages as $language) {
                $data["language"][$language['locale']] = $language['name'];
            }

            //user
            $user = $vx->user;


            $data["me"] = [
                "name" => $user->getName(),
                "language" => $user->language ?? "en",
                "style" => ($user instanceof StyleableInterface) ? $user->getStyles() : [],
                "default_page" => $user->default_page ?? "/Dashboard",
                "usergroup" => implode(",", $user->getRoles()),
                "roles" => implode(",", $user->getRoles()),
                "image" => $user instanceof User ? $user->uri("avatar") : ""
            ];

            //nav dropdown
            $data["navbar"] = [];

            $dropdown = [];

            if ($security->isGranted($vx->user, "User/setting")) {
                $dropdown[] = [
                    "label" => "Setting",
                    "icon" => "o_settings",
                    "link" => "/User/setting"
                ];
            }

            if (!$vx->view_as) {
                if ($vx->user->is("Administrators")) {
                    $dropdown[] = [
                        "label" => "View as",
                        "icon" => "o_visibility",
                        "link" => "/System/view-as"
                    ];
                }
            } else {
                $dropdown[] = ["label" => "Cancel view as", "icon" => "o_visibility_off", "link" => "/cancel-view-as"];
            }

            /* 
            outp($vx->config->toArray());
            die(); */



            $data["navbar"]["dropdown"] = $dropdown;
            $data["menu_width"] = intval($vx->config->VX->menu_width);
            $data["theme_customizer"] = boolval($vx->config->VX->theme_customizer ?? true);

            $data["i18n"] = $vx->getGlobalTranslator()->getCatalogue($vx->locale)->all()["messages"];
            $data["i18n_module"] = $vx->getModuleTranslate();
            $data["i18n_en"] = $vx->getGlobalTranslator()->getCatalogue("en")->all()["messages"];
            $data["locale"] = $vx->user->language ?? ["en"];
            $data["file_upload_max_size"] = FileManager::FormatBytes($vx->getFileUploadMaxSize());
        }

        $config = $vx->config["VX"];
        $data["config"] = [
            "company" => $config["company"],
            "copyright-year" => $config["copyright_year"],
            "copyright-url" => $config["copyright_url"],
            "copyright-name" => $config["copyright_name"],

            "company-logo" => $config["company_logo"],
            "company-url" => $config["company_url"],
            "login_version" => $config["login_version"],
            "allow_remember_me" => boolval($config["allow_remember_me"]),
            "disable_forgot_password" => boolval($config["disable_forgot_password"]),
            "css" => [],
            "js" => [],

        ];

        if ($logined) {
            $data["config"]["css"] = explode("\n", $config["css"]) ?? [];
            $data["config"]["js"] = explode("\n", $config["js"]) ?? [];
        }

        return $data;
    }

    function setNavbarColor(VX $vx)
    {
        if ($vx->user instanceof User) {
            $user = $vx->user;
            $user->style["navbar_color"] = $vx->_post["color"];
            $user->save();
        }
    }

    function setNavbarType(VX $vx)
    {
        if ($vx->user instanceof User) {

            $user = $vx->user;
            $user->style["navbar_type"] = $vx->_post["type"];
            $user->save();
        }
    }


    function setFooterType(VX $vx)
    {
        if ($vx->user instanceof User) {

            $user = $vx->user;
            $user->style["footer_type"] = $vx->_post["type"];
            $user->save();
        }
    }

    function setCollapsible(VX $vx)
    {
        if ($vx->user instanceof User) {

            $user = $vx->user;
            $user->style["collapsible"] = $vx->_post["collapsible"];
            $user->save();
        }
    }

    function setLayout(VX $vx)
    {
        if ($vx->user instanceof User) {

            $user = $vx->user;
            $user->style["layout"] = $vx->_post["layout"];
            $user->save();
        }
    }
};
