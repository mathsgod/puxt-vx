<?php

/**
 * Created by: Raymond Chong
 * Date: 2022-09-14 
 */
return new class
{
    function get()
    {
        throw new Exception("test");
        return ["hello" => "world"];
    }
};
