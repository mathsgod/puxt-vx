<div id="change_password">
    <el-card>
        <el-form :model="form" ref="form">
            <el-form-item label="New Password" required prop="new_password" class="col-12 col-sm-6">
                <el-input show-password type="password" v-model="form.new_password"></el-input>
            </el-form-item>
            <el-form-item label="Retype New Password" required prop="retype_password" class="col-12 col-sm-6">
                <el-input show-password type="password" v-model="form.retype_password"></el-input>
            </el-form-item>

            <el-form-item>
                <el-button icon="el-icon-check" @click="submit" type="primary">Save changes</el-button>
            </el-form-item>


        </el-form>

    </el-card>
</div>

<script>
    new Vue({
        el: "#change_password",
        data: {
            form: {}
        },
        methods: {
            submit() {
                this.$refs.form.validate(async valid => {
                    if (valid) {
                        if (this.form.new_password != this.form.retype_password) {
                            this.$alert("retype password not same as new password", {
                                type: "error"
                            });
                            return;
                        }
                        let resp = await this.$vx.post(null, {
                            password: this.form.new_password
                        });

                        if (resp.status == 204) {
                            this.$message.success("Password updated");
                        }
                    }
                });
            }
        },

    });
</script>

<?php

/**
 * Created by: Raymond Chong
 * Date: 2021-07-23 
 */
return new class
{
    function get(VX $vx)
    {
    }

    function post(VX $vx)
    {
        $user = $vx->object();
        if (!$user->user_id) {
            $user = $vx->user;
        }

        if ($user->canChangePasswordBy($vx->user)) {
            $user->password = password_hash($vx->_post["password"], PASSWORD_DEFAULT);
            $user->save();
            http_response_code(204);
        } else {
            http_response_code(403);
        }
    }
};
