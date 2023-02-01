<?php

/**
 * Created by: Raymond Chong
 * Date: 2021-07-05 
 */

use Laminas\Diactoros\Response\EmptyResponse;
use VX\Config;

return new class
{
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
        $schema = $vx->createSchema();
        $form = $schema->addForm();
        $form->action("/System/setting");
        $form->value($this->getData($vx));

        $form->addInput("API url", "vx_url");
        $form->addInput("Company", "company");
        $form->addInput("Company Logo", "company_logo");
        $form->addInput("Copyright name", "copyright_name");
        $form->addInput("Copyright year", "copyright_year");
        $form->addInput("Copyright url", "copyright_url");

        $form->addDivider("Login")->contentPosition("left");
        $form->addSelect("Login Version", "login_version")->options([
            [
                "label" => "Basic",
                "value" => "v1"
            ], [
                "label" => "Cover",
                "value" => "v2"
            ]
        ])->validation("required");

        $form->addSwitch("Allow remember me", "allow_remember_me");


        //token
        $form->addDivider("Token")->contentPosition("left");
        $form->addInputNumber("Access token expire", "access_token_expire")->validation("required");


        $form->addDivider("Authentication")->contentPosition("left");
        $form->addSwitch("Authentication lock", "authentication_lock");
        $form->addInputNumber("Authentication lock time", "authentication_lock_time")->validation("required");


        $form->addDivider("JWT blacklist")->contentPosition("left");
        $form->addSwitch("JWT blacklist", "jwt_blacklist");

        $form->addDivider("2 Step verification")->contentPosition("left");
        $form->addSwitch("2 Step verification", "two_step_verification");


        $form->addDivider("Biomatric authentication")->contentPosition("left");
        $form->addSwitch("Biometric authentication", "biometric_authentication")->help("Require https");

        $form->addDivider("File manager")->contentPosition("left");
        $form->addSwitch("Show file manage", "file_manager_show");

        $form->addDivider("UI")->contentPosition("left");
        $form->addInputNumber("Menu width", "menu_width")->validation("required");
        $form->addSwitch("Theme customizer", "theme_customizer");


        $form->addDivider("Password policy")->contentPosition("left");
        $form->addInputNumber("Minimum length", "password_length");
        $form->addSwitch("Upper case", "password_upper_case");
        $form->addSwitch("Lower case", "password_lower_case");
        $form->addSwitch("Number", "password_number");
        $form->addSwitch("Special character", "password_special_character");




        return $schema;
    }

    function getData(VX $vx)
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
        $config["password_upper_case"] = boolval($config["password_upper_case"]);
        $config["password_lower_case"] = boolval($config["password_lower_case"]);
        $config["password_number"] = boolval($config["password_number"]);
        $config["password_special_character"] = boolval($config["password_special_character"]);

        /** @var \Laminas\Config\Config $config */
        //filter out the configs that are not in the form
        $config = array_filter($config->toArray(), function ($key) {
            return in_array($key, [
                "vx_url",
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
                "theme_customizer",
                "password_length",
                "password_upper_case",
                "password_lower_case",
                "password_number",
                "password_special_character"

            ]);
        }, ARRAY_FILTER_USE_KEY);


        return $config;
    }
};
