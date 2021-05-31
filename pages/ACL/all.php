<div id="div1">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Permissions</h4>
        </div>
        <p class="card-text ml-2">Permission according to roles</p>

        <el-form class="ml-2">
            <el-form-item label="User Group">
                <el-select v-model="usergroup_id">
                    <el-option v-for="ug in UserGroup" :value="ug.usergroup_id" :label="ug.name"></el-option>
                </el-select>
            </el-form-item>
        </el-form>

    </div>
</div>

<script>
    new Vue({
        el: "#div1",
        data() {
            return {
                usergroup_id: null,
                UserGroup: [],
                Module: []
            }
        },
        async created() {
            this.UserGroup = (await this.$vx.get("ACL/all?_method=getUserGroup")).data;
            this.Module = (await this.$vx.get("ACL/all?_method=getModule")).data;
            console.log(this.Module);
        }
    });
</script>


<?php

use VX\UserGroup;

return [
    "methods" => [
        "getUserGroup" => function () {
            return UserGroup::Query()->toArray();
        },
        "getModule" => function (VX $vx) {
            return $vx->getModules();
        }
    ]
];
