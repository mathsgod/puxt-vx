<?php

use Carbon\Carbon;
use VX\EventLog;
use VX\UI\TableColumn;
use VX\User;
use VX\UserLog;

/**
 * Created by: Raymond Chong
 * Date: 2021-07-22 
 */
return new class
{
    function getData(VX $vx)
    {
        $user = User::FromGlobal();

        $user->UserGroups = $user->UserGroup()->toArray();

        $user->timeline = $this->getTimeline();

        $user->permission = $this->getPermission($vx);

        $user->_userlog = $this->getUserLog($vx);

        return [
            "user" => $user
        ];
    }

    private function getPermission(VX $vx)
    {
        $permission = [];
        $acl = $vx->getAcl();
        foreach ($vx->getModules() as $module) {
            $p = [];
            $p["name"] = $module->name;


            foreach (["create", "read", "update", "delete"] as $privilege) {
                $p[$privilege] = $acl->isAllowed($this->user, $module, $privilege);
            }

            $permission[] = $p;
        }
        return $permission;
    }

    private function getTimeline(): array
    {
        $user = User::FromGlobal();
        $timeline = [];
        $els = EventLog::Query(["user_id" => $user->user_id])->order(["eventlog_id" => "desc"])->limit(10);
        foreach ($els as $el) {
            $time = new Carbon($el->created_time);
            if ($el->action == "Insert") {
                $timeline[] = [
                    "type" => "success",
                    "content" => "Create a new " . $el->class,
                    "timestamp" => $time->diffForHumans()
                ];
            } elseif ($el->action == "Delete") {
                $timeline[] = [
                    "type" => "danger",
                    "content" => $el->class . " deleted",
                    "timestamp" => $time->diffForHumans()
                ];
            }
        };
        return $timeline;
    }

    private function getUserLog(VX $vx)
    {
        $user = User::FromGlobal();
        return UserLog::Query(["user_id" => $user->user_id])->limit(10)->toArray();
    }
};
