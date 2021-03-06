<template id="v-general">
    <el-card>
        <!-- header media -->
        <div class="media mb-2">
            <a href="javascript:void(0);" class="mr-25">
                <img :src="user.photo" class="rounded mr-50" alt="profile image" height="80" width="80" v-if="user.photo" />
            </a>
            <!-- upload and reset button -->
            <div class="media-body mt-75 ml-1">
                <label for="account-upload" class="btn btn-sm btn-primary mb-75 mr-75">Upload</label>
                <input type="file" id="account-upload" hidden accept="image/*" @input="inputPhoto" ref="user_img" />
                <button class="btn btn-sm btn-outline-secondary mb-75" id="reset_image" @click.prevent="reset">Reset</button>
                <p>Allowed JPG, GIF or PNG. Max size of 800kB</p>
            </div>
            <!--/ upload and reset button -->
        </div>
        <!--/ header media -->

        <!-- form -->
        <el-form :model="user" class="small-label">
            <div class="row">

                <el-form-item :label="$t('Username')" required class="col-12 col-sm-6" prop="username">
                    <el-input v-model="user.username"></el-input>
                </el-form-item>

                <el-form-item :label="$t('Email')" required :rules="[{type:'email'}]" class="col-12 col-sm-6" prop="email">
                    <el-input v-model="user.email"></el-input>
                </el-form-item>

                <el-form-item :label="$t('First name')" required class="col-12 col-sm-6" prop="first_name">
                    <el-input v-model="user.first_name"></el-input>
                </el-form-item>


                <el-form-item :label="$t('Last name')" class="col-12 col-sm-6" prop="last_name">
                    <el-input v-model="user.last_name"></el-input>
                </el-form-item>


                <div class="col-12">
                    <el-button type="primary" class="mt-2 mr-1" @click="save" v-text="$t('Save changes')"></button>
                </div>
            </div>
        </el-form>
    </el-card>
</template>

<script>
    Vue.component("v-general", {
        template: document.getElementById("v-general"),
        data() {
            return {
                user: {}
            }
        },
        async created() {
            let {
                data
            } = await this.$vx.get("setting-general")
            this.user = data.user;
            this.user.photo = this.$vx.endpoint + "User/avatar?t=" + (new Date).getTime();
        },
        methods: {
            async save() {
                let resp = await this.$vx.patch(`/User/${this.user.user_id}`, this.user);
                if (resp.status == 204) {
                    this.$message.success("User updated");
                }
            },
            async reset() {
                try {
                    await this.$confirm("Reset photo?", {
                        type: "warning"
                    });
                    await this.$vx.patch(`/User/${this.user.user_id}`, {
                        photo: null
                    });

                    await this.reloadPhoto();
                } catch {}
            },

            async inputPhoto() {
                let upload = this.$refs.user_img;
                if (upload.files.length > 0) {
                    let file = upload.files[0];
                    let fd = new FormData();
                    fd.append("file", file);
                    let resp = await this.$vx.post("change-photo", fd);
                    await this.reloadPhoto()
                }
            },

            async reloadPhoto() {
                let {
                    data
                } = await this.$vx.get("setting-general");
                this.user.photo = this.$vx.endpoint + "User/avatar?t=" + (new Date).getTime();
            }
        }
    });
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
            "username" => $user->username,
            "first_name" => $user->first_name,
            "last_name" => $user->last_name,
            "email" => $user->email,
        ]];
    }
};
