<?php

use Firebase\JWT\JWT;
use VX\Module;
use VX\ModuleGroup;
use VX\User;
use Webauthn\PublicKeyCredentialRpEntity;
use VX\PublicKeyCredentialSourceRepository;
use Webauthn\PublicKeyCredentialRequestOptions;
use Webauthn\PublicKeyCredentialSource;

return new class
{
    public function renew_access_token(VX $vx)
    {
        $refresh_token = $vx->_post["refresh_token"];
        $payload = (array)JWT::decode($refresh_token, $vx->config["VX"]["jwt"]["secret"], ["HS256"]);
        if ($payload["type"] == "refresh_token") {

            $token = JWT::encode([
                "type" => "access_token",
                "iat" => time(),
                "exp" => time() + 3600,
                "user_id" => $payload["user_id"]
            ], $vx->config["VX"]["jwt"]["secret"]);
            return ["access_token" => $token];
        }

        return ["error" => [
            "message" => "error when renew access token"
        ]];
    }

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
            "copyright-year" => $config["copyright_year"],
            "copyright-url" => $config["copyright_url"],
            "copyright-name" => $config["copyright_name"],

            "company-logo" => $config["company_logo"],
            "company-url" => $config["company_url"],
            "login" => [
                "version" => $config["login_version"]
            ]
        ];




        return $data;
    }

    public function forgetPassword(VX $vx)
    {
        $vx->forgotPassword($vx->_post["username"], $vx->_post["email"]);
    }


    public function setNavbarColor(VX $vx)
    {
        $user = $vx->user;
        $user->style["navbar_color"] = $vx->_post["color"];
        $user->save();
    }

    public function setNavbarType(VX $vx)
    {
        $user = $vx->user;
        $user->style["navbar_type"] = $vx->_post["type"];
        $user->save();
    }

    public function selectLanguage(VX $vx)
    {
        if ($user = $vx->user) {
            $user->style["language"] = $vx->_post["language"];
            $user->save();
        }
    }

    public function setFooterType(VX $vx)
    {
        $user = $vx->user;
        $user->style["footer_type"] = $vx->_post["type"];
        $user->save();
    }

    public function setCollapsible(VX $vx)
    {
        $user = $vx->user;
        $user->style["collapsible"] = $vx->_post["collapsible"];
        $user->save();
    }

    public function setLayout(VX $vx)
    {
        $user = $vx->user;
        $user->style["layout"] = $vx->_post["layout"];
        $user->save();
    }
};
