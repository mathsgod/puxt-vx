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
        return new EmptyResponse();
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
        $config["access_token_expire"] = $config["access_token_expire"] ?? 3600;
        $config["refresh_token_expire"] = $config["refresh_token_expire"] ?? 86400;
        $config["theme_customizer"] = boolval($config["theme_customizer"] ?? true);

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


        return $config;
    }
};
