{{p}}
<vue>
    {{p|raw}}
</vue>

{{p2}}
<vue>
    {{p2|raw}}
</vue>


{{p3}}
<vue>
    {{p3|raw}}
</vue>

{{p4}}
<vue>
    {{p4|raw}}
</vue>
<?php

/**
 * Created by: Raymond Chong
 * Date: 2021-10-08 
 */

use VX\UI\EL\Progress;

return new class
{
    function get(VX $vx)
    {
        $p = new Progress;
        $p->setPercentage(85);
        $this->p = $p;

        $p2 = new Progress;
        $p2->setWidth(50);
        $p2->setPercentage(80);
        $this->p2 = $p2;

        $p3 = new Progress;
        $p3->setShowText(true);
        $p3->setPercentage(80);
        $p3->setTextInside(true);
        $p3->setStrokeWidth(26);
        $this->p3 = $p3;

        $p4 = new Progress;
        $p4->setType("dashboard");
        $p4->setPercentage(80);

        $this->p4 = $p4;
    }
};
