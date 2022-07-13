<template id="v-information">
    <el-card :header="$t('Information')">
        <el-form class="small-label">
            <div class="row">
                <el-form-item :label="$t('Phone')" class="col-12">
                    <el-input v-model="user.phone"></el-input>
                </el-form-item>

                <div class="col-12">
                    <el-form-item :label="$t('Address')">
                        <el-input v-model="user.addr1"></el-input>
                    </el-form-item>
                    <el-form-item>
                        <el-input v-model="user.addr2"></el-input>
                    </el-form-item>
                    <el-form-item>
                        <el-input v-model="user.addr3"></el-input>
                    </el-form-item>

                </div>


                <div class="col-12">
                    <button type="submit" class="btn btn-primary mt-1 mr-1" @click.prevent="save">Save changes</button>
                </div>
            </div>
        </el-form>
    </el-card>
</template>

<script>
    Vue.component("v-information", {
        template: document.getElementById("v-information"),
        data() {
            return {
                user: {}
            }
        },
        async created() {
            let {
                data
            } = await this.$vx.get("setting-information");
            this.user = data.user;
        },
        methods: {
            async save() {
                let resp = await this.$vx.patch(`/User/${this.user.user_id}`, this.user);
                if (resp.status == 204) {
                    this.$message.success("User updated");
                }
            }
        }
    })
</script>

<?php

/**
 * Created by: Raymond Chong
 * Date: 2021-08-02 
 */
return new class
{

    function get(VX $vx)
    {
        $user = $vx->user;
        return ["user" => [
            "user_id" => $user->user_id,
            "phone" => $user->phone,
            "addr1" => $user->addr1,
            "addr2" => $user->addr2,
            "addr3" => $user->addr3,
        ]];
    }
};
