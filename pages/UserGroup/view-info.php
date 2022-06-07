<q-card flat bordered>
    <q-card-section>
        {{view|raw}}
    </q-card-section>
</q-card>
<?php
/**
 * Created by: Raymond Chong
 * Date: 2021-09-10 
 */
return new class
{
    function get(VX $vx)
    {
        $view = $vx->ui->createDescriptions();
        $view->add("Name", "name");
        $view->add("Code", "code");
        $view->add("Remark", "remark");

        $this->view = $view;
    }
};
