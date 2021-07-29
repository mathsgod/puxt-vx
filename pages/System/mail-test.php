<h3>under construcation</h3>
{{v|raw}}
<?php

/**
 * Created by: Raymond Chong
 * Date: 2021-07-27 
 */
return new class
{
    function get(VX $vx)
    {

        $v = $vx->ui->createForm([]);
        $v->add("Email")->email("email")->required();



        $this->v = $v;
    }
};
