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

        $lists = $schema->addQCard()->flat()->addLists();
        $lists->item("Username", $user->username);
        $lists->item("First name", $user->first_name);
        $lists->item("Last name", $user->last_name);
        $lists->item("Email", $user->email);
        $lists->item("Phone", $user->phone);
        $lists->item("Address 1", $user->addr1);
        $lists->item("Address 2", $user->addr2);
        $lists->item("Address 3", $user->addr3);
        $lists->item("Join date", $user->join_date);
        $lists->item("Language", $user->language);
        $lists->item("Default page", $user->default_page);
        $lists->item("Roles", join(",", $user->getRoles()));


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
                $list = $item->addCard($d["header"])->bodyStyle(["padding" => "0px"])->addQList();
                $list->addQItem()->addSection()->label("IP")->caption($d["data"]["ip"]);
                $list->addQItem()->addSection()->label("User Agent")->caption($d["data"]["user_agent"]);
            } else {
                $item->children($d["header"]);
            }
        }

        return $schema;
    }
};
