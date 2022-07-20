
<?php

/**
 * Created by: Raymond Chong
 * Date: 2021-08-02 
 */

use Laminas\Diactoros\Response\EmptyResponse;

return new class
{

    function delete(VX $vx)
    {

        $user = $vx->user;
        $uuid = $vx->_get["uuid"];
        $user->credential = collect($user->credential ?? [])->filter(function ($item) use ($uuid) {
            return $item["uuid"] != $uuid;
        })->toArray();

        $user->save();

        return new EmptyResponse();
    }

    function get(VX $vx)
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
};
