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
        $menu = $schema->addMenu()->router(true)->mode("horizontal");
        $menu->addMenuItem()->route("change-password")->addChildren("Change password");
        $menu->addMenuItem()->route("change-role")->addChildren("Change role");



        $desc = $schema->addDescriptions()->border()->column(1)->setClass("mt-1");

        $desc->addDescriptionsItem("Username")->addChildren($user->username);
        $desc->addDescriptionsItem("First name")->addChildren($user->first_name);
        $desc->addDescriptionsItem("Last name")->addChildren($user->last_name);
        $desc->addDescriptionsItem("Email")->addChildren($user->email);
        $desc->addDescriptionsItem("Phone")->addChildren($user->phone);
        $desc->addDescriptionsItem("Address1")->addChildren($user->addr1);
        $desc->addDescriptionsItem("Address2")->addChildren($user->addr2);
        $desc->addDescriptionsItem("Address3")->addChildren($user->addr3);
        $desc->addDescriptionsItem("Join date")->addChildren($user->join_date);
        $desc->addDescriptionsItem("Status")->addChildren($user->getStatus());
        $desc->addDescriptionsItem("Expiry date")->addChildren($user->expiry_date);

        $desc->addDescriptionsItem("Language")->addChildren($user->language);
        $desc->addDescriptionsItem("Default page")->addChildren($user->default_page);
        $desc->addDescriptionsItem("Role")->addChildren(implode(",", $user->getRoles()));







        return $schema;
    }
};
