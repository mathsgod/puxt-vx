<?php

/**
 * @author Raymond Chong
 * @date 2023-02-27 
 */

use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\TextResponse;

return new class
{
    function get(VX $vx)
    {
        $schema = $vx->createSchema();
        $schema->addChildren('$getText()');

        $btn = $schema->addButton("Button1");
        $btn->setProp("v-on:click", '$onClick');

        //        $tab = $schema->addElTabs();
        //      $tab->addPane("Pane 1")->addChildren("User/setting_test/a");
        //    $tab->addPane("Pane 2")->addChildren("User/setting_test/b");
        //  $tab->addPane("Pane 3")->addChildren("User/setting_test/c");


        /*    $tabs = $schema->addQTabs();

        $tabs->addRouteTab()->to("/User/setting_test/a")->label("A");
        $tabs->addRouteTab()->to("/User/setting_test/b")->label("B");
        $tabs->addRouteTab()->to("/User/setting_test/c")->label("C"); */


        /*         $schema->addRouterLink()->to("/User/setting_test/a")->children("A");
        $schema->addRouterLink()->to("/User/setting_test/b")->children("B");
        $schema->addRouterLink()->to("/User/setting_test/c")->children("C");
        
 */


        /*     $router_view = $schema->addComponent("RouterView");
        $router_view->addVxSchema()->src('$route.path'); */

        $token = $vx->getAccessToken();

        return [
            "component" => "http://localhost:8001/api/User/setting_test?_entry=script&_token=$token"
        ];

        return [
            "schema" => $schema,
            "data" => [
                "a" => "A",
                "b" => "B",
                "c" => "C"
            ],
            "script" => [
                "http://localhost:8001/api/User/setting_test?_entry=script&_token=$token"
            ]
        ];

        return $schema;
    }

    function script()
    {
        return new TextResponse("
        export default{
            setup(){

                return ()=>{
                    h('div', 'Hello World');
                };

            }
            
        }
", 200, [
            "Content-Type" => "application/javascript"
        ]);
    }

    function script1()
    {
        return new TextResponse("export default{
            
        getText(){
                return 'Hello World1';
        },
        onClick(){
            alert('Hello World');
        }
}
", 200, [
            "Content-Type" => "application/javascript"
        ]);
    }
};
