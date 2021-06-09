<vx-card>
    <vx-card-body>{{tab|raw}}</vx-card-body>
</vx-card>

<?php

return ["get" => function (VX $context) {
    $tab = $context->createTab();
    $tab->add("All ACL", "list");
    $this->tab = $tab;
}];
