{{table|raw}}
<?php


return new class
{
    public function get(VX $vx)
    {

        $table = $vx->ui->createTable("ds");

        $action = $table->addActionColumn();
        $action->addView();
        $action->addEdit();
        $action->addDelete();

        $table->add("Username", "username")->sortable()->searchable();
        $table->add("First name", "first_name")->sortable()->searchable();
        $table->add("Last name", "last_name")->sortable()->searchable();
        $table->add("Phone", "phone")->sortable()->searchable();
        $table->add("Email", "email")->sortable()->searchable()->overflow();
        $table->add("Join date", "join_date")->sortable()->searchable("date");


        $language = [];
        foreach ($vx->config["VX"]["language"] as $k => $v) {
            $language[] = [
                "text" => $v,
                "value" => $k
            ];
        }
        $table->add("Language", "language")->sortable()->filterable($language);
        $this->table = $table;
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
