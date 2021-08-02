<template id="v-bio-auth">
    <el-card header="Biometric authentication">
        <el-button @click="register">Register</el-button>

        <el-table :data="items">
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
                on_off: false,
                items: []
            }
        },
        created() {
            this.reload();
        },
        methods: {
            async onDelete(item) {

                await this.$confirm("Delete this record?", {
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

                localStorage.setItem("auth_first_name", this.$vx.me.first_name)
                localStorage.setItem("auth_username", this.$vx.me.username);
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