<vue>
    {{empty|raw}}
</vue>

{{empty}}

<?php
/**
 * Created by: Raymond Chong
 * Date: 2021-10-18 
 */

use VX\UI\EL\_Empty;

return new class
{
    function get(VX $vx)
    {
        $e = new _Empty;
        $this->empty = $e;
    }
};
