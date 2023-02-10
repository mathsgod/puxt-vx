<?php

/**
 * @author Raymond Chong
 * @date 2022-12-20 
 */

use Laminas\Diactoros\Response\EmptyResponse;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use Laminas\Diactoros\Response\TextResponse;
use VX\Security\Security;
use VX\User;

return new class
{
    function post(VX $vx)
    {
        //return new TextResponse("testing", 400);
        throw new Exception("testing error");

        return new EmptyResponse();
        return new EmptyResponse(204, [
            "location" => "/System/setting"
        ]);
    }

    function get(VX $vx)
    {
        $schema = $vx->createSchema();
        $form = $schema->addForm();
        $form->action("/User/test");
        $form->backOnSuccess(false);


        return $schema;
    }
};
