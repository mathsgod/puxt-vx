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
        $schema = $vx->createSchema();

        $schema->addDescriptions()
            ->item("Username", $user->name)
            ->item("First Name", $user->first_name)
            ->item("Last Name", $user->last_name)
            ->item("Email", $user->email)
            ->item("Phone", $user->phone)
            ->item("Address 1", $user->addr1)
            ->item("Address 2", $user->addr2)
            ->item("Address 3", $user->addr3)
            ->item("Join Date", $user->join_date)
            ->item("Language", $user->language)
            ->item("Default Page", $user->default_page)
            ->item("Roles", join(",", $user->getRoles()));

        $row = $schema->addRow()->setClass("mt-2")->gutter(8);

        $col = $row->addCol()->md(8);


        $card = $col->addCard("Timeline");
        $timeline = $card->addTimeline();
        foreach ($this->getTimeline($vx) as $d) {
            $timeline->addTimelineItem()
                ->timestamp($d["time"])
                ->children($d["content"]);
        }


        $card = $row->addCol()->md(16)->addCard("User Log");
        $timeline = $card->addTimeline();
        foreach ($this->getUserLog($vx) as $d) {
            $item = $timeline->addTimelineItem()
                ->timestamp($d["time"])
                ->type($d["type"]);

            if ($d["data"]) {

                $item->addCard($d["header"])->addDescriptions()
                    ->item("IP", $d["data"]["ip"])
                    ->item("User Agent", $d["data"]["user_agent"]);
            } else {
                $item->children($d["header"]);
            }
        }

        return $schema;
    }
};
