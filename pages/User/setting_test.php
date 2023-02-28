<?php

/**
 * @author Raymond Chong
 * @date 2023-02-27 
 */
return new class
{
    function get(VX $vx)
    {
        $schema = $vx->createSchema();

        //        $tab = $schema->addElTabs();
        //      $tab->addPane("Pane 1")->addChildren("User/setting_test/a");
        //    $tab->addPane("Pane 2")->addChildren("User/setting_test/b");
        //  $tab->addPane("Pane 3")->addChildren("User/setting_test/c");


        $tabs = $schema->addQTabs();

        $tabs->addRouteTab()->to("/User/setting_test/a")->label("A");
        $tabs->addRouteTab()->to("/User/setting_test/b")->label("B");
        $tabs->addRouteTab()->to("/User/setting_test/c")->label("C");


        /*         $schema->addRouterLink()->to("/User/setting_test/a")->children("A");
        $schema->addRouterLink()->to("/User/setting_test/b")->children("B");
        $schema->addRouterLink()->to("/User/setting_test/c")->children("C");
        
 */


        $router_view = $schema->addComponent("RouterView");
        $router_view->addVxSchema()->src('$route.path');

        return $schema;
    }
};
