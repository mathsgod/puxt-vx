<template id="v-change-password">
    <el-card>
        <el-form :model="form" ref="form" class="small-label">
            <div class="row">
                <el-form-item label="Old password" prop="old_password" required class="col-12">
                    <el-input type="password" v-model="form.old_password"></el-input>
                </el-form-item>

                <el-form-item :label="$t('New Password')" required prop="new_password" class="col-12" :rules="rules">
                    <el-input show-password type=" password" v-model="form.new_password">
                    </el-input>
                </el-form-item>
                <el-form-item label="Retype New Password" required prop="retype_password" class="col-12">
                    <el-input show-password type=" password" v-model="form.retype_password">
                    </el-input>
                </el-form-item>

                <div class="col-12">
                    <el-button type="primary" class="mt-1 mr-1" @click="save" v-text="$t('Save changes')"></button>
                </div>
            </div>

        </el-form>
    </el-card>
</template>


<script>
    Vue.component("v-change-password", {
        template: document.getElementById("v-change-password"),
        data() {
            return {
                rules: [],
                form: {
                    old_password: null,
                    new_password: null,
                    retype_password: null

                }
            }
        },
        async created() {
            //download password rules
            let {
                data
            } = await this.$vx.get("/User/change-password?_entry=getPasswordPolicy");
            this.rules = data;
        },
        methods: {
            save() {
                this.$refs.form.validate(async valid => {
                    if (valid) {
                        if (this.form.new_password != this.form.retype_password) {
                            this.$alert("retype password not same as new password", {
                                type: "error"
                            });
                            return;
                        }
                        let {
                            data,
                            status
                        } = await this.$vx.post("/User/change-password", {
                            old_password: this.form.old_password,
                            password: this.form.new_password
                        });


                        if (data.error) {
                            this.$message.error(data.error.message);
                            return;
                        }

                        if (status == 200) {
                            this.$message.success("Password updated");
                        }
                    }
                });
            }
        }
    });
</script>