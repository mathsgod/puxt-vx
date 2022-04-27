<div id="div1">
    <el-table :data="{{data|json_encode}}" size="small">
        <el-table-column label="Username" prop="username" sortable></el-table-column>
        <el-table-column label="First name" prop="first_name" sortable></el-table-column>
        <el-table-column label="Last name" prop="last_name" sortable></el-table-column>
        <el-table-column label="Usergroup" prop="usergroup" sortable></el-table-column>
        <el-table-column label="View as">
            <template slot-scope="scope">
                <el-button @click="viewAs(scope.row)" size="small">View as </el-button>
            </template>
        </el-table-column>
    </el-table>
</div>

<script>
    new Vue({
        el: "#div1",
        methods: {
            viewAs({
                user_id
            }) {
                this.$vx.viewAs(user_id);

                window.self.location.reload();

            }
        }

    });
</script>
<?php

use VX\User;
use VX\UserGroup;

/**
 * Created by: Raymond Chong
 * Date: 2021-08-17 
 */
return new class
{
    function get(VX $vx)
    {

        $this->data = collect(User::Query())->map(function ($o) {
            return [
                "user_id" => $o->user_id,
                "username" => $o->username,
                "first_name" => $o->first_name,
                "last_name" => $o->last_name,
                "usergroup" => collect($o->UserGroup())->map(fn (UserGroup $ug) => $ug->name)->join(", ")
            ];
        });
    }
};
