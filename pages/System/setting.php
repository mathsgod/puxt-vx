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
        $config=$vx->config["VX"];
        $config["two_step_verification"]=boolval($config["two_step_verification"]);

        $f = $vx->ui->createForm($config);
        $r = $f->add("Company");
        $r->input("company");
        $r->helpBlock("company name");


        $f->add("Company logo")->input("company_logo");
        $f->add("Company url")->input("company_url");


        $f->add("Copyright name")->input("copyright_name");
        $f->add("Copyright year")->input("copyright_year");
        $f->add("Copyright url")->input("copyright_url");

        $f->add("Login version")->select("login_version", ["v1" => "v1", "v2" => "v2"]);
        $f->addDivider();

        $f->add("2 step verification")->switch("two_step_verification");
        $f->add("Biometric authentication")->switch("biometric_authentication");

        $this->form = $f;
    }
};
