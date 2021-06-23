<vx-card>
    <vx-card-body>
        {{tab|raw}}
    </vx-card-body>
</vx-card>

<?php

return ["get" => function (VX $vx) {
    $tab = $vx->ui->createTab();
    $tab->add("All events", "list");
    $this->tab = $tab;
}];
