<?php

namespace VX;

class UserLog extends Model
{
    public function getLogoutTime()
    {
        if ($this->logout_dt) {
            return $this->logout_dt;
        }

        if (!$this->last_access_time) {
            return null;
        }

        //cal by last access time + session timeout(8 hours)
        $last_access = strtotime($this->last_access_time);
        $logout = $last_access + 8 * 60 * 60;

        if ($logout > time()) {
            return null;
        }
        return date("Y-m-d H:i:s", $logout);
    }
}
