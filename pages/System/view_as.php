<div id="div1">
    <el-table :data="{{data|json_encode}}">
        <el-table-column label="Username" prop="username"></el-table-column>
        <el-table-column label="View as">
            <template slot-scope="scope">
                <el-button @click="viewAs(scope.row)">View as </el-button>
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

return ["get" => function (VX $vx) {

    $this->data = collect(User::Query()->toArray())->map(function ($o) {
        return [
            "user_id" => $o->user_id,
            "username" => $o->username
        ];
    });
    /* 
    $t = $vx->ui->createT(User::Query());
    $t->add("Username", "username");

    $t->addHTML("View as", function ($o) {
        return html("el-link")->href("/System/view_as?" . http_build_query([
            "user_id" => $o->user_id
        ]))->text("view as");
    });
    $this->t = $t; */
}];
