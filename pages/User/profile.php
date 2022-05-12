<?php

/**
 * Created by: Raymond Chong
 * Date: 2021-08-26 
 */
return new class
{
    function get(VX $vx)
    {

        return [];
        $this->user = $vx->user;

        $this->user_photo = $vx->user->photo();

        $this->usergroup = collect($vx->user->UserGroup()->toArray())->map(function ($o) {
            return $o->name;
        })->join(", ");
    }
};
