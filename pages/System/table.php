{{table|raw}}

<?php
/**
 * Created by: Raymond Chong
 * Date: 2021-07-09 
 */

use VX\UI\EL\Table;
use VX\User;

return new class
{
    function get(VX $vx)
    {
        $table = new Table;
        $table->border()->stripe();
        $table->setData(User::Query()->map(function ($r) {
            return [
                "username" => $r->username,
                "firstname" => $r->firstname
            ];
        }));

        $table->addColumn("username", "username")->sortable();
        $table->addColumn("first name", "firstname");

        $this->table = $table;
    }
};
