<?php

use Firebase\JWT\JWT;
use Laminas\Diactoros\Response\EmptyResponse;
use Symfony\Component\Yaml\Yaml;
use VX\FileManager;
use VX\PublicKeyCredentialSourceRepository;
use VX\User;
use Webauthn\PublicKeyCredentialRequestOptions;
use Webauthn\PublicKeyCredentialSource;

return new class
{
    function get(VX $vx)
    {
        $logined = $vx->logined;
        $data = [
            "logined" => $logined,
            "version" => [
                [
                    "name" => "puxt-vx",
                    "value" => Composer\InstalledVersions::getVersion("mathsgod/puxt-vx")
                ],
                [
                    "name" => "puxt",
                    "value" => Composer\InstalledVersions::getVersion("mathsgod/puxt")
                ]
            ]
        ];


        $data["locale"] = "en";
        if ($logined) {
            //fav
            $data["favs"] = [];
            foreach ($vx->user->MyFavorite() as $fav) {
                $data["favs"][] = [
                    "label" => $fav->label,
                    "link" => $fav->path,
                    "name" => $fav->label
                ];
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




            $menu = new VX\Menu();
            $menu->setACL($vx->getAcl());
            $menu->setTranslator($vx->getTranslator());
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
            $data["language"] = $vx->config["VX"]["language"];

            //user
            $user = $vx->user;


            $data["me"] = [
                "username" => $user->username,
                "first_name" => $user->first_name,
                "last_name" => $user->last_name,
                "language" => $user->language ?? "en",
                "style" => $user->style,
                "default_page" => $user->default_page ?? "/Dashboard",
                "usergroup" => $user->UserGroup()->map(fn ($o) => $o->name)->join(","),
                "image" => $user->uri("avatar")
            ];

            //nav dropdown
            $data["navbar"] = [];

            $dropdown = [];

            if (!$vx->view_as) {
                if ($vx->user->isAdmin()) {
                    $dropdown[] = ["label" => "View as", "icon" => "eye", "link" => "/System/view-as"];
                }
            } else {
                $dropdown[] = ["label" => "Cancel view as", "icon" => "eye", "link" => "/cancel-view-as"];
            }

            $data["navbar"]["dropdown"] = $dropdown;

            $data["i18n"] = $vx->getGlobalTranslator()->getCatalogue($vx->locale)->all()["messages"];
            $data["i18n_module"] = $vx->getModuleTranslate();
            $data["i18n_en"] = $vx->getGlobalTranslator()->getCatalogue("en")->all()["messages"];
            $data["locale"] = $vx->user->language;
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
            "login" => [
                "version" => $config["login_version"]
            ],
            "allow_remember_me" => boolval($config["allow_remember_me"]),
            "css" => [],
            "js" => [],

        ];

        if ($logined) {
            $data["config"]["css"] = explode("\n", $config["css"]) ?? [];
            $data["config"]["js"] = explode("\n", $config["js"]) ?? [];
        }

        return $data;
    }



    function resetPassword(VX $vx)
    {
        $vx->resetPassword($vx->_post["password"], $vx->_post["token"]);
        return ["data" => true];
    }


    function setNavbarColor(VX $vx)
    {
        $user = $vx->user;
        $user->style["navbar_color"] = $vx->_post["color"];
        $user->save();
    }

    function setNavbarType(VX $vx)
    {
        $user = $vx->user;
        $user->style["navbar_type"] = $vx->_post["type"];
        $user->save();
    }


    function setFooterType(VX $vx)
    {
        $user = $vx->user;
        $user->style["footer_type"] = $vx->_post["type"];
        $user->save();
    }

    function setCollapsible(VX $vx)
    {
        $user = $vx->user;
        $user->style["collapsible"] = $vx->_post["collapsible"];
        $user->save();
    }

    function setLayout(VX $vx)
    {
        $user = $vx->user;
        $user->style["layout"] = $vx->_post["layout"];
        $user->save();
    }

    function addMyFavorite(VX $vx)
    {
        $user = $vx->user;
        $user->addMyFavorite($vx->_post["label"], $vx->_post["path"]);
    }

    function removeMyFavorite(VX $vx)
    {
        $user = $vx->user;
        $user->removeMyFavorite($vx->_post["path"]);
    }
};
