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
        $schema->addDivider("Form");
        $schema->addRadioGroup("form_size")->label("Size")->options([
            "large" => "Large",
            "default" => "Default",
            "small" => "Small",
        ])->validation("required");

        $schema->addDivider("Table");
        $schema->addRadioGroup("table_size")->label("Size")->options([
            "large" => "Large",
            "default" => "Default",
            "small" => "Small",
        ])->validation("required");
        $schema->addSwitch("table_border")->label("Border");

        $schema->addDivider("Descriptions");

        $schema->addRadioGroup("descriptions_size")->label("Size")->options([
            "large" => "Large",
            "default" => "Default",
            "small" => "Small",
        ])->validation("required");

        return [
            "data" => $style,
            "schema" => $schema
        ];
    }
};
