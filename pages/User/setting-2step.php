<template id="v-2step">

    <el-card>


        <div class="mb-1">
            <el-switch v-model="on_off" active-text="2 step verification">
            </el-switch>

        </div>

        <div v-if="on_off && !show_setting">
            <p>Your IP address : <span v-text="ip_address"></span></p>
            <el-button @click="addToWhitelist" type="primary">Add IP to white list</el-button>

            <el-table size="small" :data="whitelist">
                <el-table-column v-slot="scope" width="50">
                    <a @click.prevent="removeWhitelist(scope.row.value)">
                        <vx-icon name="trash" width="14"></vx-icon>
                    </a>
                </el-table-column>
                <el-table-column label="IP address" prop="value"></el-table-column>
            </el-table>
        </div>

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
    </el-card>
</template>

<script>
    Vue.component("v-2step", {
        template: document.getElementById("v-2step"),
        data() {
            return {
                whitelist: [],
                has_two_step: false,
                qr_code: null,
                code: null,
                secret: null,
                on_off: false,
                ip_address: ""
            }
        },
        async created() {
            let {
                data
            } = await this.$vx.get("User/setting-2step");
            this.has_two_step = data.has_two_step;
            this.on_off = data.has_two_step;
            this.whitelist = data.whitelist;
            this.ip_address = data.ip_address;
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
                            this.$vx.post("User/setting-2step?_entry=remove");
                            this.has_two_step = false;
                        } catch {
                            this.on_off = true;
                        }
                    }

                    return;
                } else {
                    let resp = (await this.$vx.get("User/setting-2step?_entry=qrcode")).data;
                    this.qr_code = resp.image;
                    this.secret = resp.secret
                }
            }
        },
        methods: {
            async removeWhitelist(value) {
                await this.$vx.post("User/setting-2step?_entry=removeWhitelist", {
                    ip: value
                });
                await this.loadWhitelist();
            },
            async addToWhitelist() {
                await this.$vx.post("User/setting-2step?_entry=addWhitelist");
                await this.loadWhitelist();
            },
            async loadWhitelist() {
                let {
                    data
                } = await this.$vx.get("User/setting-2step");
                this.whitelist = data.whitelist;
            },
            async onSubmit() {
                let resp = (await this.$vx.post("User/setting-2step", {
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
    })
</script>

<?php

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Google\Authenticator\GoogleAuthenticator;

/**
 * Created by: Raymond Chong
 * Date: 2021-08-02 
 */
return new class
{
    function post(VX $vx)
    {
        $post = $vx->_post;
        $g = new GoogleAuthenticator();
        if (!$g->checkCode($post["secret"], $post["code"])) {
            throw new Exception("code incorrect");
        }
        $user = $vx->user;
        $user->secret = $post["secret"];
        $user->save();
    }

    function removeWhitelist(VX $vx)
    {
        $user = $vx->user;
        $user->two_step["whitelist"] = collect($user->two_step["whitelist"] ?? [])->filter(fn ($ip) => $ip != $vx->_post["ip"])->toArray();
        $user->save();
    }

    function remove(VX $vx)
    {
        $user = $vx->user;
        $user->secret = null;
        $user->save();
        http_response_code(204);
    }

    function addWhitelist(VX $vx)
    {
        $user = $vx->user;
        $item = $user->two_step ?? [];
        $item["whitelist"][] = $_SERVER["REMOTE_ADDR"];
        $user->two_step = $item;
        $user->save();
    }


    function qrcode(VX $vx)
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

    function get(VX $vx)
    {
        $user = $vx->user;
        return [
            "has_two_step" => (bool)$user->secret,
            "whitelist" => collect($user->two_step["whitelist"] ?? [])->map(fn ($ip) => ["value" => $ip])->toArray(),
            "ip_address" => $_SERVER["REMOTE_ADDR"]
        ];
    }
};
