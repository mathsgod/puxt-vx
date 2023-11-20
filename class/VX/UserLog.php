<?php

namespace VX;

class UserLog extends Model
{
    public function getLogoutTime()
    {
        $vx = self::$_vx;
        if ($this->logout_dt) {
            return $this->logout_dt;
        }

        if (!$this->last_access_time) {
            return null;
        }

        //cal by last access time + session timeout(from setting)
        $last_access = strtotime($this->last_access_time);
        $logout = $last_access + $vx->config["VX"]["access_token_expire"];

        if ($logout > time()) {
            return null;
        }
        return date("Y-m-d H:i:s", $logout);
    }
}
