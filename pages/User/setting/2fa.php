<?php

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Google\Authenticator\GoogleAuthenticator;
use Laminas\Diactoros\Response\EmptyResponse;

/**
 * Created by: Raymond Chong
 * Date: 2021-08-02 
 */
return new class
{

    function post(VX $vx)
    {
        $post = $vx->_post;
        $g = new GoogleAuthenticator();
        if (!$g->checkCode($post["secret"], $post["code"])) {
            throw new Exception("code incorrect");
        }
        $user = $vx->user;
        $user->secret = $post["secret"];
        $user->save();
    }

    function removeWhitelist(VX $vx)
    {
        $user = $vx->user;
        $user->two_step["whitelist"] = collect($user->two_step["whitelist"] ?? [])->filter(fn ($ip) => $ip != $vx->_post["ip"])->toArray();
        $user->save();
    }

    function delete(VX $vx)
    {
        $user = $vx->user;
        $user->secret = null;
        $user->save();
        return new EmptyResponse();
    }

    function addWhitelist(VX $vx)
    {
        $user = $vx->user;
        $item = $user->two_step ?? [];
        $item["whitelist"][] = $_SERVER["REMOTE_ADDR"];
        $user->two_step = $item;
        $user->save();
    }


    function qrcode(VX $vx)
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

    function get(VX $vx)
    {
        $user = $vx->user;
        return [
            "has_two_step" => (bool)$user->secret,
            "whitelist" => collect($user->two_step["whitelist"] ?? [])->map(fn ($ip) => ["value" => $ip])->toArray(),
            "ip_address" => $_SERVER["REMOTE_ADDR"]
        ];
    }
};
