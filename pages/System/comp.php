<?php

/**
 * @author Raymond Chong
 * @date 2023-03-02 
 */
return new class
{
    function get(VX $vx)
    {

        return [
            "vue" => file_get_contents(__DIR__ . "/comp.vue"),
        ];
    }
};
