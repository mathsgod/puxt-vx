<?php


/**
 * @author Raymond Chong
 * @date 2023-02-28 
 */
return new class
{
    function get(VX $vx)
    {
        $schema = $vx->createSchema();

        $schema->addChildren("User/testing/b");

        return $schema;
    }
};
