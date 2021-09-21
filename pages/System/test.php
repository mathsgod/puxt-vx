{{a}}
<?php

/**
 * Created by: Raymond Chong
 * Date: 2021-09-10 
 */
return new class
{
    function get(VX $vx)
    {
        sleep(3);
        $this->a = $vx->_get["a"];
    }
};
