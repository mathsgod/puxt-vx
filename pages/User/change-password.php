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
                        let {
                            status,
                            data
                        } = await this.$vx.post("change-password", {
                            password: this.form.new_password
                        });

                        if (data.error) {
                            this.$message.error(data.error.message);
                            return;
                        }

                        if (status == 200) {
                            this.$message.success("Password updated");
                            this.$vx.$router.push("view");
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

use League\Route\Http\Exception\BadRequestException;
use League\Route\Http\Exception\ForbiddenException;
use League\Route\Http\Exception\UnauthorizedException;
use VX\User;

return new class
{
    function post(VX $vx)
    {
        $user = User::FromGlobal();

        if (!$user->user_id) {
            $user = $vx->user;
        }

        if (!password_verify($vx->_post["old_password"], $user->password)) {
            throw new BadRequestException("Old password is incorrect");
        }

        //regexp check for password
        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[#$@!%&*?])[A-Za-z\d#$@!%&*?]{12,}$/', $vx->_post["new_password"])) {
            throw new BadRequestException("Password must be at least 12 characters long, include at least one uppercase character, at least one lowercase character, at least one special character or symbol, and at least one digit");
        }

        if (!$user->canChangePasswordBy($vx->user)) {
            throw new ForbiddenException("You are not allowed to change this user's password");
        }

        $user->password = password_hash($vx->_post["password"], PASSWORD_DEFAULT);
        $user->save();
    }

    function getPasswordPolicy(VX $vx)
    {
        $rules = [];


        if ($vx->config["VX"]["password policy"]["min length"]) {
            $rules[] = [
                "pattern" => "^.{" . $vx->config["VX"]["password policy"]["min length"] . ",}$",
                "message" => "Password must be at least " . $vx->config["VX"]["password policy"]["min length"] . " characters long"
            ];
        }

        if ($vx->config["VX"]["password policy"]["uppercase character"]) {
            $rules[] = [
                "pattern" => "^(?=.*[A-Z])",
                "message" => "Password must include at least one uppercase character"
            ];
        }


        if ($vx->config["VX"]["password policy"]["lowercase character"]) {
            $rules[] = [
                "pattern" => "^(?=.*[a-z])",
                "message" => "Password must include at least one lowercase character"
            ];
        }

        if ($vx->config["VX"]["password policy"]["special character"]) {
            $rules[] = [
                "pattern" => "^(?=.*[#$@!%&*?])",
                "message" => "Password must include at least one special character or symbol"
            ];
        }

        if ($vx->config["VX"]["password policy"]["digit"]) {
            $rules[] = [
                "pattern" => "^(?=.*\d)",
                "message" => "Password must include at least one digit"
            ];
        }

        return $rules;
    }
};
