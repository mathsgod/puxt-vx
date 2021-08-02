<?php
include_once(__DIR__ . "/setting-general.php");
include_once(__DIR__ . "/setting-change-password.php");
include_once(__DIR__ . "/setting-information.php");
include_once(__DIR__ . "/setting-style.php");
include_once(__DIR__ . "/setting-2step.php");
include_once(__DIR__ . "/setting-bio-auth.php");
?>

<div id="div1">
    <el-row :gutter="25">
        <el-col :md="6">
            <vx-nav v-model="selected" pills class="flex-column nav-left">
                <vx-nav-item index="v-general" icon="fa fa-user fa-fw">General</vx-nav-item>
                <vx-nav-item index="v-change-password" icon="fa fa-key fa-fw">{{'Change Password'|t}}</vx-nav-item>
                <vx-nav-item index="v-information" icon="fa fa-info fa-fw">{{'Information'|t}}</vx-nav-item>
                <vx-nav-item index="v-style" icon="fa fa-brush fa-fw">{{'Style'|t}}</vx-nav-item>
                {% if two_step_verification %}
                <vx-nav-item index="v-2step" icon="fa fa-lock fa-fw"> 2 Step Verification</vx-nav-item>
                {% endif %}
                {% if biometric_authentication %}
                <vx-nav-item index="v-bio-auth" icon="fa fa-fingerprint fa-fw">{{'Biometric authentication'|t}}</vx-nav-item>
                {% endif %}
            </vx-nav>
        </el-col>

        <el-col :md="18">
            <component :is="selected"></component>
        </el-col>
    </el-row>
</div>

<script>
    new Vue({
        el: "#div1",
        i18n,
        data() {
            return {
                selected: "v-general",
            }
        }
    });
</script>

<?php

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Google\Authenticator\GoogleAuthenticator;

return new class
{

    function get(VX $vx)
    {
        $config = $vx->config["VX"];
        $this->two_step_verification = boolval($config["two_step_verification"]);
        $this->biometric_authentication = boolval($config["biometric_authentication"]);
    }

    function removeCredential(VX $vx)
    {

        $user = $vx->user;
        $uuid = $vx->_post["uuid"];
        $user->credential = collect($user->credential ?? [])->filter(function ($item) use ($uuid) {
            return $item["uuid"] != $uuid;
        })->toArray();

        $user->save();
    }

    function getCredential(VX $vx)
    {
        return collect($vx->user->credential ?? [])->map(function ($item) {
            return [
                "uuid" => $item["uuid"],
                "ip" => $item["ip"],
                "time" => date("Y-m-d H:i:s", $item["timestamp"]),
                "user-agent" => $item["user-agent"]
            ];
        })->toArray();
    }


    function two_step_qrcode(VX $vx)
    {
        $user = $vx->user;

        $g = new GoogleAuthenticator();
        $secret = $g->generateSecret();

        $host = $_SERVER["HTTP_HOST"];


        $url = sprintf("otpauth://totp/%s@%s?secret=%s", $user->username, $host, $secret);

        $writer = new PngWriter();
        $png = $writer->write(QrCode::create($url));
        return [
            "secret" => $secret,
            "host" => $host,
            "image" => $png->getDataUri()
        ];
    }

    function two_step(VX $vx)
    {
        $user = $vx->user;


        return [
            "has_two_step" => (bool)$user->secret
        ];
    }

    function post(VX $vx)
    {
        $post = $vx->_post;
        if ($post["type"] == "style") {
            $user = $vx->user;
            foreach ($post["data"] as $k => $v) {
                $user->style[$k] = $v;
            }
            $user->save();

            http_response_code(204);

            return;
        }

        if ($post["type"] == "two_step") {
            $g = new GoogleAuthenticator();
            if (!$g->checkCode($post["secret"], $post["code"])) {
                throw new Exception("code incorrect");
            }
            $user = $vx->user;
            $user->secret = $post["secret"];
            $user->save();
            return;
        }

        if ($post["type"] == "remove_2step") {
            $user = $vx->user;
            $user->secret = null;
            $user->save();
            http_response_code(204);
            return;
        }
    }

    function style(VX $vx)
    {
        $user = $vx->user;
        $style = $user->style ?? [];
        return $style;
    }


    function general(VX $vx)
    {
        $user = $vx->user;
        return ["user" => [
            "photo" => $user->photo(),
            "user_id" => $user->user_id,
            "username" => $user->username,
            "first_name" => $user->first_name,
            "last_name" => $user->last_name,
            "email" => $user->email,
        ]];
    }

    function info(VX $vx)
    {
        $user = $vx->user;
        return ["user" => [
            "user_id" => $user->user_id,
            "phone" => $user->phone,
            "addr1" => $user->addr1,
            "addr2" => $user->addr2,
            "addr3" => $user->addr3,
        ]];
    }
};
