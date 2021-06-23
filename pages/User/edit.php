<!-- users edit start -->
<section class="app-user-edit">
    <div class="card">
        <div class="card-body">
            <ul class="nav nav-pills" role="tablist">
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center active" id="account-tab" data-toggle="tab" href="#account" aria-controls="account" role="tab" aria-selected="true">
                        <i class="fa fa-user"></i><span class="d-none d-sm-block">Account</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center" id="information-tab" data-toggle="tab" href="#information" aria-controls="information" role="tab" aria-selected="false">
                        <i class="fa fa-info"></i><span class="d-none d-sm-block">Information</span>
                    </a>
                </li>

            </ul>
            <div class="tab-content">
                <!-- Account Tab starts -->
                <div class="tab-pane active" id="account" aria-labelledby="account-tab" role="tabpanel">
                    <!-- users edit media object start -->
                    <div class="media mb-2">
                        <img src="http://localhost:8001/vx/images/user.png" alt="users avatar" class="user-avatar users-avatar-shadow rounded mr-2 my-25 cursor-pointer" height="90" width="90" />
                        <div class="media-body mt-50">
                            <h4>{{user.first_name}} {{user.last_name}}</h4>
                            <div class="col-12 d-flex mt-1 px-0">
                                <label class="btn btn-primary mr-75 mb-0" for="change-picture">
                                    <span class="d-none d-sm-block">Change</span>
                                    <input class="form-control" type="file" id="change-picture" hidden accept="image/png, image/jpeg, image/jpg" />
                                    <span class="d-block d-sm-none">
                                        <i class="mr-0" data-feather="edit"></i>
                                    </span>
                                </label>
                                <button class="btn btn-outline-secondary d-none d-sm-block">Remove</button>
                                <button class="btn btn-outline-secondary d-block d-sm-none">
                                    <i class="mr-0" data-feather="trash-2"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- users edit media object ends -->
                    <!-- users edit account form start -->
                    <el-form :model="form" ref="form1">
                        <div class="row">
                            <div class="col-md-4">
                                <el-form-item label="Username" prop="username" required>
                                    <el-input v-model="form.username"></el-input>
                                </el-form-item>
                            </div>
                            <div class="col-md-4">
                                <el-form-item label="First name" prop="first_name" required>
                                    <el-input v-model="form.first_name"></el-input>
                                </el-form-item>
                            </div>
                            <div class="col-md-4">
                                <el-form-item label="Last name" prop="last_name">
                                    <el-input v-model="form.last_name"></el-input>
                                </el-form-item>
                            </div>
                            <div class="col-md-4">
                                <el-form-item label="Email" prop="email" :rules="[{type:'email'}]" required>
                                    <el-input v-model="form.email" type="email"></el-input>
                                </el-form-item>
                            </div>

                            <div class="col-md-4">
                                <el-form-item label="Status" prop="status">
                                    <div>
                                        <el-select v-model='form.status' style="width: 100%">
                                            <el-option :value="0" label="Active"></el-option>
                                            <el-option :value="1" label="Inactve"></el-option>
                                        </el-select>
                                    </div>
                                </el-form-item>
                            </div>

                            <div class="col-md-12">
                                <el-form-item label="User group">
                                    <el-select multiple v-model="form.usergroup_id" style="width: 100%">
                                        <el-option v-for="ug in UserGroup" :value="ug.usergroup_id" :label="ug.name"></el-option>
                                    </el-select>
                                </el-form-item>

                            </div>
                            <div class="col-12 d-flex flex-sm-row flex-column mt-2">
                                <button type="submit" class="btn btn-primary mb-1 mb-sm-0 mr-0 mr-sm-1" @click.prevent="save">Save Changes</button>
                                <button type="reset" class="btn btn-outline-secondary">Reset</button>
                            </div>
                        </div>
                        </form>
                        <!-- users edit account form ends -->
                </div>
                <!-- Account Tab ends -->

                <!-- Information Tab starts -->
                <div class="tab-pane" id="information" aria-labelledby="information-tab" role="tabpanel">
                    <!-- users edit Info form start -->
                    <form class="form-validate">
                        <div class="row mt-1">
                            <div class="col-12">
                                <h4 class="mb-1">
                                    <i data-feather="user" class="font-medium-4 mr-25"></i>
                                    <span class="align-middle">Personal Information</span>
                                </h4>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <label for="birth">Birth date</label>
                                    <input id="birth" type="text" class="form-control birthdate-picker" name="dob" placeholder="YYYY-MM-DD" />
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <label for="mobile">Mobile</label>
                                    <input id="mobile" type="text" class="form-control" value="&#43;6595895857" name="phone" />
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <label for="website">Website</label>
                                    <input id="website" type="text" class="form-control" placeholder="Website here..." value="https://rowboat.com/insititious/Angelo" name="website" />
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <label for="languages">Languages</label>
                                    <select id="languages" class="form-control">
                                        <option value="English">English</option>
                                        <option value="Spanish">Spanish</option>
                                        <option value="French" selected>French</option>
                                        <option value="Russian">Russian</option>
                                        <option value="German">German</option>
                                        <option value="Arabic">Arabic</option>
                                        <option value="Sanskrit">Sanskrit</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <label class="d-block mb-1">Gender</label>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="male" name="gender" class="custom-control-input" />
                                        <label class="custom-control-label" for="male">Male</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="female" name="gender" class="custom-control-input" checked />
                                        <label class="custom-control-label" for="female">Female</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <label class="d-block mb-1">Contact Options</label>
                                    <div class="custom-control custom-checkbox custom-control-inline">
                                        <input type="checkbox" class="custom-control-input" id="email-cb" checked />
                                        <label class="custom-control-label" for="email-cb">Email</label>
                                    </div>
                                    <div class="custom-control custom-checkbox custom-control-inline">
                                        <input type="checkbox" class="custom-control-input" id="message" checked />
                                        <label class="custom-control-label" for="message">Message</label>
                                    </div>
                                    <div class="custom-control custom-checkbox custom-control-inline">
                                        <input type="checkbox" class="custom-control-input" id="phone" />
                                        <label class="custom-control-label" for="phone">Phone</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <h4 class="mb-1 mt-2">
                                    <i data-feather="map-pin" class="font-medium-4 mr-25"></i>
                                    <span class="align-middle">Address</span>
                                </h4>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <label for="address-1">Address Line 1</label>
                                    <input id="address-1" type="text" class="form-control" value="A-65, Belvedere Streets" name="address" />
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <label for="address-2">Address Line 2</label>
                                    <input id="address-2" type="text" class="form-control" placeholder="T-78, Groove Street" />
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <label for="postcode">Postcode</label>
                                    <input id="postcode" type="text" class="form-control" placeholder="597626" name="zip" />
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <label for="city">City</label>
                                    <input id="city" type="text" class="form-control" value="New York" name="city" />
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <label for="state">State</label>
                                    <input id="state" type="text" class="form-control" name="state" placeholder="Manhattan" />
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <label for="country">Country</label>
                                    <input id="country" type="text" class="form-control" name="country" placeholder="United States" />
                                </div>
                            </div>
                            <div class="col-12 d-flex flex-sm-row flex-column mt-2">
                                <button type="submit" class="btn btn-primary mb-1 mb-sm-0 mr-0 mr-sm-1">Save Changes</button>
                                <button type="reset" class="btn btn-outline-secondary">Reset</button>
                            </div>
                        </div>
                    </form>
                    <!-- users edit Info form ends -->
                </div>
                <!-- Information Tab ends -->


            </div>
        </div>
    </div>
</section>
<!-- users edit ends -->
<script>
    vx.get(location.pathname + "?_entry=account").then((resp) => {
        resp = resp.data;
        let user = resp.user;
        new Vue({
            el: "#account",
            data() {
                return {
                    UserGroup: resp.UserGroup,
                    form: user
                }
            },
            methods: {
                save() {
                    this.$refs.form1.validate(async valid => {
                        if (valid) {
                            this.$vx.patch(`User/${user.user_id}`, {
                                username: this.form.username,
                                first_name: this.form.first_name,
                                last_name: this.form.last_name
                            });
                        }
                    });

                }
            }
        });

    });
</script>

<?php

use VX\UserGroup;

return [
    "get" => function (VX $vx) {
        $this->user = $vx->object();
    },
    "entries" => [
        "account" => function (VX $vx) {

            $user = $vx->object();
            $user->usergroup_id = collect($user->UserGroup()->toArray())->map(
                function ($o) {
                    return $o->usergroup_id;
                }
            )->toArray();

            return [
                "user" => $user,
                "UserGroup" => UserGroup::Query()->toArray()
            ];
        }
    ]
];
