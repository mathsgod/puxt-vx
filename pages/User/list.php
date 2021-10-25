{{table|raw}}
<?php

use P\HTMLTemplateElement;
use VX\UI\Avatar;
use VX\User;

return new class
{
    public function get(VX $vx)
    {

        $table = $vx->ui->createTable("ds");

        $action = $table->addActionColumn();
        $action->addView();
        $action->addEdit();
        $action->addDelete();

        $table->add("", "avatar")->template(function (HTMLTemplateElement $template) {

            $av = new Avatar();
            $av->setAttribute(":title", "scope.row.name");
            $template->innerHTML = $av;
        })->width("60");

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
            $rt->source->where(["status" => $vx->_get["t"]]);
        }

        $rt->add("name", fn (User $user) => $user->__toString());
        return $rt;
    }
};
