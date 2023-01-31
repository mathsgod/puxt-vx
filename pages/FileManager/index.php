<?php

/**
 * @author Raymond Chong
 * @date 2023-01-31 
 */
return new class
{
    function get(VX $vx)
    {
        $schema = $vx->createSchema();

        $schema->addComponent("VxFileManager");
        return $schema;
    }
};
