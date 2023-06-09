<?php

/**
 * @author Raymond Chong
 * @date 2023-02-08 
 */

use Psr\Http\Message\ServerRequestInterface;

return new class
{
    function get(VX $vx, ServerRequestInterface $request)
    {

        $schema = $vx->createSchema();

        //$schema->addHidden()
        $table = $schema->addVxTable();


        $table->query("User?fields[]=initial&fields[]=getStatus&fields[]=getRoles");

        $table->addActionColumn()->addEditButton()->addViewButton()->addDeleteButton();
        $table->addColumn("Username", "username")->sortable()->searchable();
        $col = $table->addColumn("First name", "first_name")->sortable()->searchable();

        $path = $request->getUri()->withPath("/api/User/")->__toString();
        $col->addComponent("XInput")
            ->setProp("name", "first_name")
            ->setProp("modelValue", '$row.first_name')
            ->setProp("action", '$: "' . $path . '"+$row.user_id');

        $table->addColumn("Last name", "last_name")->sortable()->searchable();


        $column = $table->addColumn();

        $avatar = $column->addComponent("QAvatar", [
            "color" => "primary",
            "text-color" => "white",
            "size" => "sm",
        ]);

        $avatar->for(["item", "key", '$row'])
            ->if('$key==initial')
            ->children('$item');


        $table->addColumn("Email", "email")->sortable()->searchable();
        $table->addColumn("Role")
            ->addComponent("ElTag")
            ->for(["item", "key", '$row'])
            ->if('$key==getRoles')
            ->children('$item');

        $table->addColumn("Join date", "join_date")->sortable()->searchable("date");

        $languages = [];
        foreach ($vx->languages as $l) {
            $languages[] = [
                "label" => $l["name"],
                "value" => $l["locale"]
            ];
        }

        $table->addColumn("Language", "language")->sortable()->searchable("select")->searchOptions($languages)
            ->addComponent("XSelect")
            ->setProp("name", "language")
            ->setProp("modelValue", '$row.language')
            ->setProp("action", '$: "' . $path . '"+$row.user_id')
            ->setProp("options", $languages);

        $table->addColumn("Status", "getStatus")->sortable();

        return $schema;
    }
};
