{{table|raw}}
<?php

return new class
{
    public function get(VX $vx)
    {
        $rt = $vx->ui->createRTable("ds");

        $rt->addView();
        $rt->addEdit();
        $rt->addDel();

        $rt->add("Username", "username")->ss();
        $rt->add("First name", "first_name")->ss();
        $rt->add("Last name", "last_name")->ss();
        $rt->add("Phone", "phone")->ss();
        $rt->add("Email", "email")->ss();
        $rt->add("Join date", "join_date");
        $rt->add("Language", "language");

        $this->table = $rt;
    }

    public function ds(VX $vx)
    {
        $rt = $vx->ui->createRTableResponse();
        $rt->source = VX\User::Query();
        return $rt;
    }
};
