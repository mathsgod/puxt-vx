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
                        <span class="font-weight-bold">{{ "Change Password"|t}}</span>
                    </a>
                </li>
                <!-- information -->
                <li class="nav-item">
                    <a class="nav-link" id="account-pill-info" data-toggle="pill" href="#account-vertical-info" aria-expanded="false">
                        <i class="fa fa-info fa-fw" class="font-medium-3 mr-1"></i>
                        <span class="font-weight-bold">Information</span>
                    </a>
                </li>

                <!-- style -->
                <li class="nav-item">
                    <a class="nav-link" id="account-pill-style" data-toggle="pill" href="#account-vertical-style" aria-expanded="false">
                        <i class="fa fa-brush fa-fw" class="font-medium-3 mr-1"></i>
                        <span class="font-weight-bold">Style</span>
                    </a>
                </li>

                {% if two_step_verification %}
                <!-- 2step verification -->
                <li class="nav-item">
                    <a class="nav-link" id="account-pill-2step" data-toggle="pill" href="#account-vertical-2step" aria-expanded="false">
                        <i class="fa fa-lock fa-fw" class="font-medium-3 mr-1"></i>
                        <span class="font-weight-bold">2 Step Verification</span>
                    </a>
                </li>
                {% endif %}

                {% if biometric_authentication %}
                <!-- Bio metric -->
                <li class="nav-item">
                    <a class="nav-link" id="account-pill-bio" data-toggle="pill" href="#account-vertical-bio" aria-expanded="false">
                        <i class="fa fa-fingerprint fa-fw" class="font-medium-3 mr-1"></i>
                        <span class="font-weight-bold">Biometric Authentication</span>
                    </a>
                </li>
                {% endif %}
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
                                <el-form :model="user" class="small-label">
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
                                <el-form :model="form" ref="form" class="small-label">
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
                                <el-form class="small-label">
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

                        <!-- style -->
                        <div class="tab-pane fade" id="account-vertical-style" role="tabpanel" aria-labelledby="account-pill-info" aria-expanded="false">
                            <div id="style">

                                <el-form label-width="auto">
                                    <el-form-item label="Form size">
                                        <el-select v-model="form.form_size" clearable>
                                            <el-option value="large" label="large"></el-option>
                                            <el-option value="medium" label="medium"></el-option>
                                            <el-option value="small" label="small"></el-option>
                                            <el-option value="mini" label="mini"></el-option>
                                        </el-select>
                                    </el-form-item>

                                    <el-form-item label="List view size">
                                        <el-select v-model="form.rtable_size" clearable>
                                            <el-option value="large" label="large"></el-option>
                                            <el-option value="medium" label="medium"></el-option>
                                            <el-option value="small" label="small"></el-option>
                                            <el-option value="mini" label="mini"></el-option>
                                        </el-select>
                                    </el-form-item>

                                    <el-form-item label="List view small table">
                                        <el-checkbox v-model="form.rtable_small_table"></el-checkbox>
                                    </el-form-item>

                                    <el-form-item label="Table size">
                                        <el-select v-model="form.table_size" clearable>
                                            <el-option value="large" label="large"></el-option>
                                            <el-option value="medium " label="medium"></el-option>
                                            <el-option value="small" label="small"></el-option>
                                            <el-option value="mini" label="mini"></el-option>
                                        </el-select>
                                    </el-form-item>

                                    <el-form-item label="Table border">
                                        <el-switch v-model="form.table_border"></el-switch>
                                    </el-form-item>

                                    <button type="submit" class="btn btn-primary mt-1 mr-1" @click.prevent="submit">Save changes</button>


                                </el-form>

                            </div>
                        </div>
                        <!--/ style -->

                        <!-- 2step -->
                        <div class="tab-pane fade" id="account-vertical-2step" role="tabpanel" aria-labelledby="account-pill-info" aria-expanded="false">
                            <div id="two_step">

                                <el-switch v-model="on_off" active-text="2 step verification">
                                </el-switch>

                                <div v-if="show_setting">
                                    <p>Now download the app and scan the qrcode. Input the code to the following input and submit</p>
                                    <p>
                                        For Android user, install
                                        <el-link type="primary" target="_blank" href="https://play.google.com/store/apps/details?id=com.azure.authenticator">Authenticator</el-link>
                                    </p>

                                    <p>
                                        For iOS user, install
                                        <el-link type="primary" target="_blank" href="https://apps.apple.com/us/app/microsoft-authenticator/id983156458">Authenticator</a>
                                    </p>

                                    <el-image :src="qr_code"></el-image>

                                    <el-form>
                                        <el-form-item label="Code">
                                            <el-input v-model="code" placeholder="6 digits code" minlength="6" maxlength="6" />
                                        </el-form-item>
                                        <el-button type="primary" @click="onSubmit">Submit</el-button>
                                    </el-form>

                                </div>
                            </div>
                        </div>
                        <!--/ 2step -->

                        <div class="tab-pane fade" id="account-vertical-bio" role="tabpanel" aria-labelledby="account-pill-info" aria-expanded="false">
                            <div id="bio">

                                <el-switch v-model="on_off" active-text="Biometric authentication">
                                </el-switch>
                            </div>
                        </div>


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
                        let resp = await this.$vx.post("User/change-photo", fd);
                        console.log(resp);
                    }
                },

                async reloadPhoto() {
                    let resp = (await this.$vx.get("User/setting?_entry=general")).data;
                    this.user.photo = resp.user.photo;
                }


            }
        });
    });

    vx.get("User/setting?_entry=style").then(resp => {

        new Vue({
            el: "#style",
            data() {
                return {
                    form: resp.data
                }
            },
            methods: {
                async submit() {
                    let resp = await this.$vx.post("User/setting", {
                        type: "style",
                        data: this.form
                    });

                    if (resp.status == 204) {
                        this.$message.success("style updated");
                    }
                }
            }
        });

    });

    vx.get("User/setting?_entry=two_step").then(resp => {
        new Vue({
            el: "#two_step",
            data: {
                has_two_step: resp.data.has_two_step,
                qr_code: null,
                code: null,
                secret: null,
                on_off: resp.data.has_two_step
            },
            computed: {
                show_setting() {
                    if (this.on_off && !this.has_two_step) {
                        return true;
                    }
                    return false;
                }
            },
            watch: {
                async on_off() {
                    //get this qrcode
                    if (!this.on_off) { //turn it off

                        if (this.has_two_step) {
                            try {
                                await this.$confirm("Remove 2 step verification? You need to do setup process if you enable at next time.")

                                //do remove
                                this.$vx.post("User/setting", {
                                    type: "remove_2step"
                                });

                                this.has_two_step = false;
                            } catch {
                                this.on_off = true;
                            }
                        }

                        return;
                    } else {
                        let resp = (await this.$vx.get("User/setting?_entry=two_step_qrcode")).data;
                        this.qr_code = resp.image;
                        this.secret = resp.secret
                    }
                }
            },
            methods: {
                async onSubmit() {
                    let resp = (await this.$vx.post("User/setting", {
                        type: "two_step",
                        code: this.code,
                        secret: this.secret
                    })).data;

                    if (resp.error) {
                        this.$message.error(resp.error.message);
                        return;
                    }

                    this.$message.success("2 Step verification updated");

                    this.has_two_step = true;

                    this.code = null;

                }
            }

        });
    });

    vx.get("User/setting?_entry=bio").then(resp => {

        new Vue({
            el: "#bio",
            data: {
                on_off: false
            },
            watch: {
                async on_off() {

                    if (this.on_off) {

                        let resp = (await this.$vx.get("User/setting?_entry=bio")).data;

                        console.log("on");

                    }

                }
            }
        });
    });
</script>

<?php

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Google\Authenticator\GoogleAuthenticator;

return new class
{

    function get(VX $vx)
    {
        $config = $vx->config["VX"];
        $this->two_step_verification = boolval($config["two_step_verification"]);
        $this->biometric_authentication = boolval($config["biometric_authentication"]);
    }

    function bio(VX $vx)
    {
    }


    function two_step_qrcode(VX $vx)
    {
        $user = $vx->user;

        $g = new GoogleAuthenticator();
        $secret = $g->generateSecret();

        $host = $_SERVER["HTTP_HOST"];


        $url = sprintf("otpauth://totp/%s@%s?secret=%s", $user->username, $host, $secret);

        $writer = new PngWriter();
        $png = $writer->write(QrCode::create($url));
        return [
            "secret" => $secret,
            "host" => $host,
            "image" => $png->getDataUri()
        ];
    }

    function two_step(VX $vx)
    {
        $user = $vx->user;


        return [
            "has_two_step" => (bool)$user->secret
        ];
    }

    function post(VX $vx)
    {
        $post = $vx->_post;
        if ($post["type"] == "style") {
            $user = $vx->user;
            foreach ($post["data"] as $k => $v) {
                $user->style[$k] = $v;
            }
            $user->save();

            http_response_code(204);

            return;
        }

        if ($post["type"] == "two_step") {
            $g = new GoogleAuthenticator();
            if (!$g->checkCode($post["secret"], $post["code"])) {
                throw new Exception("code incorrect");
            }
            $user = $vx->user;
            $user->secret = $post["secret"];
            $user->save();
            return;
        }

        if ($post["type"] == "remove_2step") {
            $user = $vx->user;
            $user->secret = null;
            $user->save();
            http_response_code(204);
            return;
        }
    }

    function style(VX $vx)
    {
        $user = $vx->user;
        $style = $user->style ?? [];
        return $style;
    }


    function general(VX $vx)
    {
        $user = $vx->user;
        return ["user" => [
            "photo" => $user->photo(),
            "user_id" => $user->user_id,
            "username" => $user->username,
            "first_name" => $user->first_name,
            "last_name" => $user->last_name,
            "email" => $user->email,
        ]];
    }

    function info(VX $vx)
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
