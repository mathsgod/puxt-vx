{{form|raw}}
<?php

/**
 * Created by: Raymond Chong
 * Date: 2021-07-05 
 */

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
        http_response_code(204);
    }

    function get(VX $vx)
    {
        $config = $vx->config["VX"];
        $config["two_step_verification"] = boolval($config["two_step_verification"]);
        $config["biometric_authentication"] = boolval($config["biometric_authentication"]);
        $config["file_manager_show"] = boolval($config["file_manager_show"]);
        $config["authentication_lock"] = boolval($config["authentication_lock"]);
        $config["allow_remember_me"] = boolval($config["allow_remember_me"]);

        $f = $vx->ui->createForm($config);

        $f->add("VX URL")->input("vx_url");

        $r = $f->add("Company");
        $r->input("company");
        $r->helpBlock("company name");


        $f->add("Company logo")->input("company_logo");
        $f->add("Company url")->input("company_url");


        $f->add("Copyright name")->input("copyright_name");
        $f->add("Copyright year")->input("copyright_year");
        $f->add("Copyright url")->input("copyright_url");

        $f->add("Login version")->select("login_version", ["v1" => "v1", "v2" => "v2"]);



        $f->add("Email from")->email("mail_from");

        $f->addDivider("Login")->setContentPosition("left");
        $f->add("Allow remember me")->checkbox("allow_remember_me");



        $f->addDivider("Authentication failed lock")->setContentPosition("left");
        $f->add("Authentication lock")->switch("authentication_lock");
        $f->add("Lockout time (sec)")->inputNumber("authentication_lock_time");


        $f->addDivider("2 step verification")->setContentPosition("left");
        $f->add("2 Step verification")->switch("two_step_verification");
        $f->add("White list")->input("two_step_verification_whitelist");

        $f->addDivider();

        $r = $f->add("Biometric authentication");
        $r->switch("biometric_authentication");
        $r->helpBlock("Only https can use Biometric authentication");

        $f->addDivider("File manager")->setContentPosition("left");
        $f->add("Show file manager")->switch("file_manager_show");

        $f->addDivider();
        $f->add("Custom css")->textarea("css");

        $f->add("Custom js")->textarea("js");

        $this->form = $f;
    }
};
