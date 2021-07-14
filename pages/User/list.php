{{table|raw}}
<?php

return new class
{
    public function get(VX $vx)
    {



        $table = $vx->ui->createTable("ds");
        $table->addView();
        $table->addEdit();
        $table->addDel();
        $table->add("Username", "username")->sortable();
        $table->add("First name", "first_name")->sortable();
        $table->add("Last name", "last_name")->sortable();
        $table->add("Phone", "phone")->sortable();
        $table->add("Email", "email")->sortable();
        $table->add("Join date", "join_date")->sortable();


        $language = [];
        foreach ($vx->config["VX"]["language"] as $k => $v) {
            $language[] = [
                "text" => $v,
                "value" => $k
            ];
        }
        $table->add("Language", "language")->sortable()->filterable($language);




        $this->table = $table;
        return;

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

        //$this->table = $rt;
    }

    public function ds(VX $vx)
    {
        $rt = $vx->ui->createTableResponse();
        $rt->source = VX\User::Query();

        if ($vx->_get["t"] !== null) {
            $rt->source->filter(["status" => $vx->_get["t"]]);
        }

        $rt->add("username");
        $rt->add("first_name");
        $rt->add("last_name");
        $rt->add("phone");
        $rt->add("email");
        $rt->add("join_date");
        $rt->add("language");
        return $rt;
    }
};
