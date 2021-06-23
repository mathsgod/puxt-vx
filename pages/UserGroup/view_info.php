<vx-card>
    {{view|raw}}
</vx-card>
<?php
return ["get" => function (VX $vx) {


    $view = $vx->ui->createView();
    $view->add("Name", "name");
    //$view->add("Code", "code");
    $view->add("Remark", "remark");

    $this->view = $view;
}];
