<vue>
{{link|raw}}
</vue>

<?php

/**
 * Created by: Raymond Chong
 * Date: 2021-09-23 
 */

use VX\User;

return new class
{
    function get(VX $vx)
    {


        $this->link = $vx->ui->createLink($vx->user, "view");
    }
};
