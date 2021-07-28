<template id="v-2step">

    <el-card>


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
    </el-card>
</template>

<script>
    Vue.component("v-2step", {
        template: document.getElementById("v-2step"),
        data() {
            return {
                has_two_step: false,
                qr_code: null,
                code: null,
                secret: null,
                on_off: false

            }
        },
        async created() {
            let {
                data
            } = await this.$vx.get("User/setting?_entry=two_step");
            this.has_two_step = data.has_two_step;
            this.on_off = data.has_two_step;
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
    })
</script>