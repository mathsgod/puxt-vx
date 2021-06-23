<vx-card>
    <vx-card-body>{{tab|raw}}</vx-card-body>
</vx-card>

<?php

return new class
{
    public function get(VX $vx)
    {
        $tab = $vx->ui->createTab();
        $tab->add("All ACL", "list");
        $this->tab = $tab;
    }
};
