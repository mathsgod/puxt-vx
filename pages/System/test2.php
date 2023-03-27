<?php

/**
 * @author Raymond Chong
 * @date 2023-03-02 
 */
return new class
{
    function get(VX $vx)
    {
        $fs=$vx->getFileSystem();
        
        die();

        return [
            "hello" => "world"
        ];
    }
};
