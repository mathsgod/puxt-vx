<?php

/**
 * @author Raymond Chong
 * @date 2023-01-30 
 */

use VX\User;

return new class
{
    function get(VX $vx)
    {

        $user = User::FromGlobal();

        $schema = $vx->createSchema();

        $toolbar = $schema->addQToolbar();
        $toolbar->addQBtn()->to("change-password")->rounded()->outline()->color("primary")->appendHTML("Change password");
        $toolbar->addQBtn()->to("change-role")->rounded()->outline()->color("primary")->appendHTML("Change role");

        $div = $schema->addElement("div", ["class" => "row q-col-gutter-md"]);

        $list = $div->addElement("div", ["class" => "col-12 col-md-6"])->addQCard()->flat()
            ->addQList()->separator();

        $list->item("Username", $user->username);
        $list->item("First name", $user->first_name);
        $list->item("Last name", $user->last_name);
        $list->item("Email", $user->email);
        $list->item("Phone", $user->phone);


        $list = $div->addElement("div", ["class" => "col-12 col-md-6"])->addQCard()->flat()
            ->addQList()->separator();


        $list->item("Address1", $user->addr1);
        $list->item("Address2", $user->addr2);
        $list->item("Address3", $user->addr3);
        $list->item("Join date", $user->join_date);
        $list->item("Status", $user->getStatus());
        $list->item("Expiry date", $user->expiry_date);
        $list->item("Language", $user->language);
        $list->item("Default page", $user->default_page);
        $list->item("Role", implode(",", $user->getRoles()));



        return $schema;
    }
};
