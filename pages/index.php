<?php

use VX\Module;
use VX\ModuleGroup;
use VX\User;
use Webauthn\PublicKeyCredentialRpEntity;
use VX\PublicKeyCredentialSourceRepository;
use Webauthn\PublicKeyCredentialRequestOptions;
use Webauthn\PublicKeyCredentialSource;

return new class
{
    public function post(VX $vx)
    {
        if ($vx->_get["action"] == "auth_options") {


            $rp = new PublicKeyCredentialRpEntity($_SERVER["HTTP_HOST"]);
            $source = new PublicKeyCredentialSourceRepository();
            $server = new Webauthn\Server($rp, $source);

            // UseEntity found using the username.
            $userEntity = $vx->findWebauthnUserByUsername($vx->_post["username"]);

            // Get the list of authenticators associated to the user
            $credentialSources = $source->findAllForUserEntity($userEntity);

            // Convert the Credential Sources into Public Key Credential Descriptors
            $allowedCredentials = array_map(function (PublicKeyCredentialSource $credential) {
                return $credential->getPublicKeyCredentialDescriptor();
            }, $credentialSources);

            // We generate the set of options.
            $publicKeyCredentialRequestOptions = $server->generatePublicKeyCredentialRequestOptions(
                PublicKeyCredentialRequestOptions::USER_VERIFICATION_REQUIREMENT_PREFERRED, // Default value
                $allowedCredentials
            );


            return $publicKeyCredentialRequestOptions->jsonSerialize();
        }

        if ($vx->_get["action"] == "auth") {
        }

        $body = $vx->req->getParsedBody();

        switch ($body["action"]) {
            case "selectedLanguage":
                $user = $vx->user;
                $user->language = $body["data"];
                $user->save();
                break;
            case "navbar_color":
                $user = $vx->user;
                $user->style["navbar_color"] = $body["data"];
                $user->save();
                break;
            case "navbar_type":
                $user = $vx->user;
                $user->style["navbar_type"] = $body["data"];
                $user->save();
                break;
            case "forgot_password":
                $vx->forgotPassword($body["data"]["username"], $body["data"]["email"]);
                break;
        }
        return ["code" => 200];
    }

    public function get(VX $vx)
    {

        $logined = $vx->logined;
        $data = [
            "logined" => $logined
        ];

        if ($logined) {
            $modules = $vx->getModules();

            $menu = new VX\Menu();
            foreach ($modules as $m) {
                $menu->addModule($m);
            }

            $data["menus"] = $menu->getMenuByUser($vx->user);

            //language 
            $data["language"] = $vx->config["VX"]["language"];

            //user
            $user = $vx->user;


            $data["me"] = [
                "first_name" => $user->first_name,
                "last_name" => $user->last_name,
                "language" => $user->language ?? "en",
                "style" => $user->style,
                "default_page" => $user->default_page,
                "usergroup" => collect($user->UserGroup()->toArray())->map(function ($o) {
                    return $o->name;
                })->join(","),
                "image" => $user->photo()
            ];

            //nav dropdown
            $data["navbar"] = [];

            $dropdown = [];

            if (!$vx->view_as) {
                $dropdown[] = ["label" => "View as", "icon" => "fa fa-eye", "link" => "/System/view_as"];
            } else {
                $dropdown[] = ["label" => "Cancel view as", "icon" => "fa fa-eye", "link" => "/System/cancel_view_as"];
            }

            $data["navbar"]["dropdown"] = $dropdown;


            $data["acl"] = $vx->acl;
        }

        $config = $vx->config["VX"];
        $data["config"] = [
            "company" => $config["company"],
            "copyright-year" => $config["copyright-year"],
            "copyright-url" => $config["copyright-url"],
            "copyright-name" => $config["copyright-name"],

            "company-logo" => "http://localhost:8001/vx/images/logo.png",
            "company-url" => "https://www.hostlink.com.hk",
            "login" => [
                "version" => "v1"
            ]
        ];




        return $data;
    }
};
