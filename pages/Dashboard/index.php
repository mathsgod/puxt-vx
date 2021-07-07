
<?php

return new class
{
    public function get(VX $vx)
    {


        $modules = $vx->getModules();

        $menu = new VX\Menu();
        foreach ($modules as $m) {
            $menu->addModule($m);
        }

        outp($menu->getMenuByUser($vx->user));

    }
};
