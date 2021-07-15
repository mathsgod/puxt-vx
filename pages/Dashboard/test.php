<vue>
    <vx-table remote="/Dashboard/test?_entry=data" :pagination="false" v-slot:default="table">
        <el-table-column v-slot:default="scope">
            <el-button @click="table.reload()">click</el-button>
        </el-table-column>
        <el-table-column label="Username" prop="username"></el-table-column>
        <el-table-column label="First name" prop="first_name"></el-table-column>
        <el-table-column label="Last name" prop="last_name"></el-table-column>

    </vx-table>
</vue>

<?php

/**
 * Created by: Raymond Chong
 * Date: 2021-07-15 
 */
return new class
{
    function get(VX $vx)
    {
    }

    function data(VX $vx)
    {

        $resp = $vx->ui->createTableResponse();
        $resp->source = VX\User::Query();

        $resp->add("username");
        $resp->add("first_name");
        $resp->add("last_name");
        return $resp;
    }
};
