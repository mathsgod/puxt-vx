<?php

/**
 * Created by: Raymond Chong
 * Date: 2022-05-12 
 */

use Laminas\Diactoros\Response\EmptyResponse;
use VX\StyleableInterface;

return new class
{
    function post(VX $vx)
    {
        if ($vx->user instanceof StyleableInterface) {
            $style = $vx->user->getStyles();
            foreach ($vx->_post as $k => $v) {
                $style[$k] = $v;
            }
            $vx->user->setStyles($style);
        }

        return new EmptyResponse(200);
    }

    function get(VX $vx)
    {
        if ($vx->user instanceof StyleableInterface) {
            $style = $vx->user->getStyles();
        } else {
            $style = [];
        }

        $schema = $vx->createSchema();
        $form = $schema->addForm();
        $form->value($style);
        $form->showBack(false)->header("Style");
        $form->action("/User/setting/style");
        $form->addDivider("Form");
        $form->addRadioGroup("Size", "form_size")->options([
            "large" => "Large",
            "default" => "Default",
            "small" => "Small",
        ])->validation("required");

        $form->addDivider("Table");
        $form->addRadioGroup("Size", "table_size")->options([
            "large" => "Large",
            "default" => "Default",
            "small" => "Small",
        ])->validation("required");
        $form->addSwitch("Border", "table_border");

        $form->addDivider("Descriptions");

        $form->addRadioGroup("Size", "descriptions_size")->options([
            "large" => "Large",
            "default" => "Default",
            "small" => "Small",
        ])->validation("required");

        return $schema;
    }
};
