{{body|raw}}
<?php
/**
 * Created by: Raymond Chong
 * Date: 2021-07-12 
 */
return new class
{
    function get(VX $vx)
    {
        $this->body = $vx->object()->body;
    }
};
