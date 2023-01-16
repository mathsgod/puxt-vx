<?php

/**
 * Created by: Raymond Chong
 * Date: 2021-08-26 
 */

use VX\EventLog;
use VX\UserLog;

return new class
{
    function getTimeline(VX $vx)
    {

        $q = EventLog::Query(["user_id" => $vx->user->user_id])->order("eventlog_id desc")->limit(10);

        $data = [];
        foreach ($q as $d) {

            if ($d->action == "Insert") {
                $data[] = [
                    "time" => $d->created_time,
                    "content" => $d->class . " created",
                ];
            }

            if ($d->action == "Delete") {
                $data[] = [
                    "time" => $d->created_time,
                    "content" =>  $d->class . " deleted",
                ];
            }

            if ($d->action == "Update") {
                $data[] = [
                    "time" => $d->created_time,
                    "content" =>  $d->class . " updated",
                ];
            }
        }

        return $data;
    }

    function getUserLog(VX $vx)
    {
        $q = UserLog::Query(["user_id" => $vx->user->user_id])->order("userlog_id desc")->limit(10);

        $data = [];
        foreach ($q as $d) {

            if ($d->logout_dt) {
                $item = [];
                $item["time"] = $d->logout_dt;
                $item["header"] = "Logout";
                $item["type"] = "success";
                $data[] = $item;
            }


            $item = [
                "time" => $d->login_dt,
                "header" => "Login " . ($d->result == "SUCCESS" ? "success" : "failed"),
            ];

            if ($d->result == "SUCCESS") {
                $item["type"] = "success";
            } else {
                $item["type"] = "danger";
            }

            $item["data"] = [
                "user_agent" => $d->user_agent,
                "ip" => $d->ip
            ];
            $data[] = $item;
        }

        return $data;
    }
    function get(VX $vx)
    {
        $user = $vx->user;
        return [
            "profile" => [
                "username" => $user->username,
                "first_name" => $user->first_name,
                "last_name" => $user->last_name,
                "email" => $user->email,
                "phone" => $user->phone,
                "addr1" => $user->addr1,
                "addr2" => $user->addr2,
                "addr3" => $user->addr3,
                "join_date" => $user->join_date,
                "language" => $user->language,
                "default_page" => $user->default_page,
                "getRoles" => join(",", $user->getRoles())
            ],
            "timelines" => $this->getTimeline($vx),
            "userlogs" => $this->getUserLog($vx)
        ];
    }
};
