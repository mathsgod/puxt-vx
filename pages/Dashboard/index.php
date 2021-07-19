<vue>
<router-link to="/User/ae">user</router-link>
</vue>


<?php

return new class
{
    public function get(VX $vx)
    {



        return;
        $modules = $vx->getModules();

        $menu = new VX\Menu();
        foreach ($modules as $m) {
            $menu->addModule($m);
        }

        outp($menu->getMenuByUser($vx->user));
    }
};
