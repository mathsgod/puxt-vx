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
        $toolbar->addQBtn()->to("change-password")->rounded()->outline()->color("primary")->addChildren("Change password");
        $toolbar->addQBtn()->to("change-role")->rounded()->outline()->color("primary")->addChildren("Change role");

        $div = $schema->addElement("div")->attrs(["class" => "row q-col-gutter-md"]);

        $list = $div->addElement("div")->attrs(["class" => "col-12 col-md-6"])->addQCard()->flat()
            ->addQList()->separator();
        $item = $list->addQItem();
        $item->addSection("Username");
        $item->addSection($user->username)->side();

        $item = $list->addQItem();
        $item->addSection("First name");
        $item->addSection($user->first_name)->side();

        $item = $list->addQItem();
        $item->addSection("Last name");
        $item->addSection($user->last_name)->side();

        $item = $list->addQItem();
        $item->addSection("Email");
        $item->addSection($user->email)->side();

        $item = $list->addQItem();
        $item->addSection("Phone");
        $item->addSection($user->phone)->side();



        $list = $div->addElement("div")->attrs(["class" => "col-12 col-md-6"])->addQCard()->flat()
            ->addQList()->separator();
        $item = $list->addQItem();
        $item->addSection("Address1");
        $item->addSection($user->addr1)->side();

        $item = $list->addQItem();
        $item->addSection("Address2");
        $item->addSection($user->addr2)->side();

        $item = $list->addQItem();
        $item->addSection("Address3");
        $item->addSection($user->addr3)->side();

        $item = $list->addQItem();
        $item->addSection("Join date");
        $item->addSection($user->join_date)->side();

        $item = $list->addQItem();
        $item->addSection("Status");
        $item->addSection($user->getStatus())->side();

        $item = $list->addQItem();
        $item->addSection("Expiry date");
        $item->addSection($user->expiry_date)->side();

        $item = $list->addQItem();
        $item->addSection("Language");
        $item->addSection($user->language)->side();

        $item = $list->addQItem();
        $item->addSection("Default page");
        $item->addSection($user->default_page)->side();

        $item = $list->addQItem();
        $item->addSection("Role");
        $item->addSection(implode(",", $user->getRoles()))->side();



        return $schema;
    }
};
