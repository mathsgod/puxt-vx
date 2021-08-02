<template id="v-bio-auth">
    <el-card :header="$t('Biometric authentication')">

        <el-switch v-model="on_off" active-text="Activate biometric authentication on this device" @change="changeActivate"></el-switch>
        <el-divider></el-divider>
        <el-button @click="register">Register</el-button>



        <el-table :data="items" size="mini">
            <el-table-column width="50" v-slot="scope">
                <a @click.prevent="onDelete(scope.row)">
                    <vx-icon name="trash" width="14"></vx-icon>
                </a>
            </el-table-column>
            <el-table-column label="Time" prop="time" sortable></el-table-column>
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
                await this.$vx.post("User/setting?_entry=removeCredential", {
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
                } = await this.$vx.get("User/setting?_entry=getCredential");
                this.items = data;

            }
        },

    })
</script>