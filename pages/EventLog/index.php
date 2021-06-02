<el-card>
    {{tab|raw}}
</el-card>

<?php

return ["get" => function (VX $context) {
    $tab = $context->createTab();
    $tab->add("All events", "list");
    $this->tab = $tab;
}];
