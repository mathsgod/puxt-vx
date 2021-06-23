<!-- account setting page -->
<section id="page-account-settings">
    <div class="row">
        <!-- left menu section -->
        <div class="col-md-3 mb-2 mb-md-0">
            <ul class="nav nav-pills flex-column nav-left">
                <!-- general -->
                <li class="nav-item">
                    <a class="nav-link active" id="account-pill-general" data-toggle="pill" href="#account-vertical-general" aria-expanded="true">
                        <i class="fa fa-user fa-fw" class="font-medium-3 mr-1"></i>
                        <span class="font-weight-bold">General</span>
                    </a>
                </li>
                <!-- change password -->
                <li class="nav-item">
                    <a class="nav-link" id="account-pill-password" data-toggle="pill" href="#account-vertical-password" aria-expanded="false">
                        <i class="fa fa-key fa-fw" class="font-medium-3 mr-1"></i>
                        <span class="font-weight-bold">Change Password</span>
                    </a>
                </li>
                <!-- information -->
                <li class="nav-item">
                    <a class="nav-link" id="account-pill-info" data-toggle="pill" href="#account-vertical-info" aria-expanded="false">
                        <i class="fa fa-info fa-fw" class="font-medium-3 mr-1"></i>
                        <span class="font-weight-bold">Information</span>
                    </a>
                </li>
            </ul>
        </div>
        <!--/ left menu section -->

        <!-- right content section -->
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <div class="tab-content">
                        <!-- general tab -->
                        <div role="tabpanel" class="tab-pane active" id="account-vertical-general" aria-labelledby="account-pill-general" aria-expanded="true">
                            <div id="general">
                                <!-- header media -->
                                <div class="media">
                                    <a href="javascript:void(0);" class="mr-25">
                                        <img :src="user.photo" class="rounded mr-50" alt="profile image" height="80" width="80" />
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
                                <el-form :model="user">
                                    <div class="row">

                                        <el-form-item label="Username" required class="col-12 col-sm-6" prop="username">
                                            <el-input v-model="user.username"></el-input>
                                        </el-form-item>

                                        <el-form-item label="Email" required :rules="[{type:'email'}]" class="col-12 col-sm-6" prop="email">
                                            <el-input v-model="user.email"></el-input>
                                        </el-form-item>

                                        <el-form-item label="First name" required class="col-12 col-sm-6" prop="first_name">
                                            <el-input v-model="user.first_name"></el-input>
                                        </el-form-item>


                                        <el-form-item label="Last name" class="col-12 col-sm-6" prop="last_name">
                                            <el-input v-model="user.last_name"></el-input>
                                        </el-form-item>


                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary mt-2 mr-1" @click.prevent="save">Save changes</button>
                                        </div>
                                    </div>
                                </el-form>
                            </div>
                        </div>
                        <!--/ general tab -->

                        <!-- change password -->
                        <div class="tab-pane fade" id="account-vertical-password" role="tabpanel" aria-labelledby="account-pill-password" aria-expanded="false">
                            <div id="password">
                                <el-form :model="form" ref="form">
                                    <div class="row">
                                        <el-form-item label="New Password" required prop="new_password" class="col-12 col-sm-6">
                                            <el-input show-password type="password" v-model="form.new_password"></el-input>
                                        </el-form-item>
                                        <el-form-item label="Retype New Password" required prop="retype_password" class="col-12 col-sm-6">
                                            <el-input show-password type="password" v-model="form.retype_password"></el-input>
                                        </el-form-item>

                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary mr-1 mt-1" @click.prevent="submit">Save changes</button>
                                        </div>
                                    </div>

                                </el-form>
                            </div>
                            <script>
                                new Vue({
                                    el: "#password",
                                    data() {
                                        return {
                                            form: {}
                                        }
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
                                                    let resp = await this.$vx.post("User/change-password", {
                                                        password: this.form.new_password
                                                    });

                                                    if (resp.status == 204) {
                                                        this.$message.success("Password updated");
                                                    }
                                                }
                                            });
                                        }
                                    }
                                });
                            </script>

                        </div>
                        <!--/ change password -->

                        <!-- information -->
                        <div class="tab-pane fade" id="account-vertical-info" role="tabpanel" aria-labelledby="account-pill-info" aria-expanded="false">
                            <div id="info">
                                <el-form>
                                    <div class="row">
                                        <el-form-item label="Phone" class="col-12">
                                            <el-input v-model="user.phone"></el-input>
                                        </el-form-item>

                                        <div class="col-12">
                                            <el-form-item label="Address">
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
                                            <button type="submit" class="btn btn-primary mt-1 mr-1" @click.prevent="submit">Save changes</button>
                                        </div>
                                    </div>
                                </el-form>
                            </div>
                        </div>
                        <!--/ information -->


                    </div>
                </div>
            </div>
        </div>
        <!--/ right content section -->
    </div>
</section>
<!-- / account setting page -->

<script>
    //info
    vx.get("User/setting?_entry=info").then(resp => {
        new Vue({
            el: "#info",
            data() {
                return resp.data
            },
            methods: {
                async submit() {
                    let resp = await this.$vx.patch(`User/${this.user.user_id}`, this.user);
                    if (resp.status == 204) {
                        this.$message.success("User updated");
                    }
                }
            }
        });
    });

    vx.get("User/setting?_entry=general").then((resp) => {
        new Vue({
            el: "#general",
            data() {
                return {
                    user: resp.data.user
                }
            },
            methods: {
                async save() {
                    let resp = await this.$vx.patch(`User/${this.user.user_id}`, this.user);
                    if (resp.status == 204) {
                        this.$message.success("User updated");
                    }
                },
                async reset() {
                    try {
                        await this.$confirm("Reset photo?", {
                            type: "warning"
                        });
                        await this.$vx.patch(`User/${this.user.user_id}`, {
                            photo: null
                        });

                        await this.reloadPhoto();
                    } catch {}
                },

                async inputPhoto() {
                    let upload = this.$refs.user_img;
                    if (upload.files.length == 1) {
                        let file = upload.files[0];
                        let fd = new FormData();
                        fd.append("file", file);
                        await vx.post("User/change-photo", fd);
                    }
                },

                async reloadPhoto() {
                    let resp = (await this.$vx.get("User/setting?_entry=general")).data;
                    this.user.photo = resp.user.photo;
                }


            }
        });
    });
</script>

<?php

return ["entries" => [
    "general" => function (VX $vx) {
        $user = $vx->user;
        return ["user" => [
            "photo" => $user->photo(),
            "user_id" => $user->user_id,
            "username" => $user->username,
            "first_name" => $user->first_name,
            "last_name" => $user->last_name,
            "email" => $user->email,
        ]];
    },
    "info" => function (VX $vx) {
        $user = $vx->user;
        return ["user" => [
            "user_id" => $user->user_id,
            "phone" => $user->phone,
            "addr1" => $user->addr1,
            "addr2" => $user->addr2,
            "addr3" => $user->addr3,
        ]];
    }

]];
