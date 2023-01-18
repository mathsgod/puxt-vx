<?php

/**
 * Created by: Raymond Chong
 * Date: 2021-07-05 
 */

use Laminas\Diactoros\Response\EmptyResponse;
use VX\Config;

return new class
{

    function schema()
    {

        $schema = new FormKit\Schema();

        $schema->addFormKit("elFormInput", [
            "label" => "API url",
            "name" => "vx_url",
        ]);

        $schema->addFormKit("elFormInput", [
            "label" => "Company",
            "name" => "company",
        ]);

        $schema->addFormKit("elFormInput", [
            "label" => "Company Logo",
            "name" => "company_logo",
        ]);

        $schema->addFormKit("elFormInput", [
            "label" => "Copyright name",
            "name" => "copyright_name",
        ]);

        $schema->addFormKit("elFormInput", [
            "label" => "Copyright year",
            "name" => "copyright_year",
        ]);

        $schema->addFormKit("elFormInput", [
            "label" => "Copyright url",
            "name" => "copyright_url",
        ]);

        //login
        $schema->addComponent("ElDivider", [
            "props" => [
                "contentPosition" => "left"
            ],
            "children" => "Login"
        ]);

        $schema->addFormKit("elFormSelect", [
            "label" => "Login Version",
            "name" => "login_version",
            "options" => [
                [
                    "label" => "Basic",
                    "value" => "v1"
                ], [
                    "label" => "Cover",
                    "value" => "v2"
                ]
            ],
            "validation" => "required"
        ]);


        $schema->addFormKit("elFormCheckbox", [
            "label" => "Allow remember me",
            "name" => "allow_remember_me",
        ]);


        //token

        $schema->addComponent("ElDivider", [
            "props" => [
                "contentPosition" => "left"
            ],
            "children" => "Token"
        ]);

        $schema->addFormKit("elFormInputNumber", [
            "label" => "Access token expire",
            "name" => "access_token_expire",
            "validation" => "required"
        ]);

        $schema->addComponent("ElDivider", [
            "props" => [
                "contentPosition" => "left"
            ],
            "children" => "Authentication failed lock"
        ]);

        $schema->addFormKit("elFormSwitch", [
            "label" => "Authentication lock",
            "name" => "authentication_lock",
        ]);

        $schema->addFormKit("elFormInputNumber", [
            "label" => "Authentication lock time",
            "name" => "authentication_lock_time",
            "validation" => "required"
        ]);

        $schema->addFormKit("elFormSwitch", [
            "label" => "JWT blacklist",
            "name" => "jwt_blacklist",
        ]);

        $schema->addComponent("ElDivider", [
            "props" => [
                "contentPosition" => "left"
            ],
            "children" => "2 Step verification"
        ]);

        $schema->addFormKit("elFormSwitch", [
            "label" => "2 Step verification",
            "name" => "two_step_verification",
        ]);


        $schema->addComponent("ElDivider", [
            "props" => [
                "contentPosition" => "left"
            ],
            "children" => "Biomatric authentication"
        ]);

        $schema->addFormKit("elFormSwitch", [
            "label" => "Biometric authentication",
            "name" => "biometric_authentication",
            "help" => "Require https"
        ]);

        $schema->addComponent("ElDivider", [
            "props" => [
                "contentPosition" => "left"
            ],
            "children" => "File manager"
        ]);

        $schema->addFormKit("elFormSwitch", [
            "label" => "Show file manage",
            "name" => "file_manager_show",
        ]);


        $schema->addComponent("ElDivider", [
            "props" => [
                "contentPosition" => "left"
            ],
            "children" => "UI"
        ]);

        $schema->addFormKit("elFormInputNumber", [
            "label" => "Menu width",
            "name" => "menu_width",
            "validation" => "required"
        ]);

        $schema->addFormKit("elFormSwitch", [
            "label" => "Theme customizer",
            "name" => "theme_customizer",
        ]);

        return $schema;
    }
    function post(VX $vx)
    {
        foreach ($vx->_post as $name => $value) {
            $config = Config::CreateOrLoad($name);
            $config->value = $value;
            $config->save();
        }
        return new EmptyResponse(200);
    }

    function get(VX $vx)
    {
        $config = $vx->config["VX"];
        $config["two_step_verification"] = boolval($config["two_step_verification"]);
        $config["biometric_authentication"] = boolval($config["biometric_authentication"]);
        $config["file_manager_show"] = boolval($config["file_manager_show"]);
        $config["authentication_lock"] = boolval($config["authentication_lock"]);
        $config["allow_remember_me"] = boolval($config["allow_remember_me"]);
        $config["authentication_lock_time"] = intval($config["authentication_lock_time"]);
        $config["file_manager_preview"] = boolval($config["file_manager_preview"]);
        $config["jwt_blacklist"] = boolval($config["jwt_blacklist"]);
        $config["access_token_expire"] = $config["access_token_expire"];
        $config["theme_customizer"] = boolval($config["theme_customizer"]);

        /** @var \Laminas\Config\Config $config */
        //filter out the configs that are not in the form
        $config = array_filter($config->toArray(), function ($key) {
            return in_array($key, [
                "company",
                "company_logo",
                "company_logo_url",
                "copyright_year",
                "copyright_url",
                "copyright_name",
                "login_version",
                "search-form",
                "domain",
                "two_step_verification",
                "biometric_authentication",
                "file_manager_show",
                "authentication_lock",
                "allow_remember_me",
                "authentication_lock_time",
                "smtp",
                "smtp-username",
                "smtp-password",
                "smtp-post",
                "smtp-auto-tls",
                "return-path",
                "password-length",
                "log-save",
                "development",
                "file_manager_show",
                "allow_rememeber_me",
                "file_manager_preview",
                "jwt_blacklist",
                "access_token_expire",
                "refresh_token_expire",
                "menu_width",
                "theme_customizer"

            ]);
        }, ARRAY_FILTER_USE_KEY);


        return ["data" => $config, "schema" => $this->schema()];
    }
};
