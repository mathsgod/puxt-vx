<vue>

    <table class="table table-hover">
        <thead>
            <tr>
                <th>a</th>
                <th>b</th>
                <th>c</th>
            </tr>

        </thead>
        <tr>
            <td>a</td>
            <td>b</td>
            <td>c</td>
        </tr>
        <tr>
            <td>a</td>
            <td>b</td>
            <td>c</td>
        </tr>
        <tr>
            <td>a</td>
            <td>b</td>
            <td>c</td>
        </tr>
    </table>
    <vx-table remote="/Dashboard/test?_entry=data" :pagination="false" v-slot:default="table">
        <el-table-column v-slot:default="scope">
            <el-button @click="table.reload()">click</el-button>
        </el-table-column>
        <el-table-column label="Username" prop="username"></el-table-column>
        <el-table-column label="First name" prop="first_name"></el-table-column>
        <el-table-column label="Last name" prop="last_name"></el-table-column>

    </vx-table>

    <vx-card>
        <vx-card-body>body</vx-card-body>
    </vx-card>

    <el-card>
        el-card
    </el-card>
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
