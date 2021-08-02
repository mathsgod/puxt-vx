<template id="v-bio-auth">
    <el-card :header="$t('Biometric authentication')">
        <el-switch v-model="on_off" :active-text="$t('Activate biometric authentication on this device')" @change="changeActivate"></el-switch>
        <el-divider></el-divider>
        <el-button @click="register">Register</el-button>

        <el-table :data="items" size="mini">
            <el-table-column width="50" v-slot="scope">
                <a @click.prevent="onDelete(scope.row)">
                    <vx-icon name="trash" width="14"></vx-icon>
                </a>
            </el-table-column>
            <el-table-column :label="$t('Time')" prop="time" sortable></el-table-column>
            <el-table-column label="IP" prop="ip"></el-table-column>
            <el-table-column label="User agent" prop="user-agent"></el-table-column>
        </el-table>
    </el-card>
</template>

<script>
    Vue.component("v-bio-auth", {
        template: document.getElementById("v-bio-auth"),
        data() {
            return {
                items: [],
                on_off: false,
            }
        },
        created() {
            this.reload();
            if (localStorage.getItem("auth_username") == this.$vx.me.username) {
                this.on_off = true;
            }
        },
        methods: {
            changeActivate(value) {
                if (value) {
                    localStorage.setItem("auth_username", this.$vx.me.username);
                } else {
                    localStorage.removeItem("auth_username");
                }
            },
            async onDelete(item) {

                await this.$confirm(this.$t("Delete this record?"), {
                    type: "warning"
                });
                await this.$vx.post("User/setting-bio-auth?_entry=removeCredential", {
                    uuid: item.uuid
                });
                await this.reload();
            },
            async register() {
                let data = await this.$vx.authRegister();

                if (data.error) {
                    this.$alert(data.error.message, {
                        type: "error"
                    });
                    return;
                }

                this.$message("Register success", {
                    type: "success"
                });
                await this.reload();

                localStorage.setItem("auth_username", this.$vx.me.username);
                this.on_off = true;
            },
            async reload() {
                let {
                    data
                } = await this.$vx.get("User/setting-bio-auth?_entry=getCredential");
                this.items = data;

            }
        },

    })
</script>

<?php

/**
 * Created by: Raymond Chong
 * Date: 2021-08-02 
 */
return new class
{

    function removeCredential(VX $vx)
    {

        $user = $vx->user;
        $uuid = $vx->_post["uuid"];
        $user->credential = collect($user->credential ?? [])->filter(function ($item) use ($uuid) {
            return $item["uuid"] != $uuid;
        })->toArray();

        $user->save();
    }

    function getCredential(VX $vx)
    {
        return collect($vx->user->credential ?? [])->map(function ($item) {
            return [
                "uuid" => $item["uuid"],
                "ip" => $item["ip"],
                "time" => date("Y-m-d H:i:s", $item["timestamp"]),
                "user-agent" => $item["user-agent"]
            ];
        })->toArray();
    }
};
