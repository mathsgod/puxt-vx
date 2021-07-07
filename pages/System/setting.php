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
        $f = $vx->ui->createForm($vx->config["VX"]);
        $f->add("Company")->input("company");
        $f->add("Company logo")->input("company_logo");
        $f->add("Company url")->input("company_url");


        $f->add("Copyright name")->input("copyright_name");
        $f->add("Copyright year")->input("copyright_year");
        $f->add("Copyright url")->input("copyright_url");

        $f->add("Login version")->select("login_version", ["v1" => "v1", "v2" => "v2"]);
        $this->form = $f;
    }
};
