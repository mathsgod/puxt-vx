<template id="v-bio-auth">
    <el-card>
        <el-switch v-model="on_off" active-text="Biometric authentication">
        </el-switch>
    </el-card>
</template>

<script>
    Vue.component("v-bio-auth", {
        template: document.getElementById("v-bio-auth"),
        data() {
            return {
                on_off: false
            }
        },
        watch: {
            async on_off() {

                if (this.on_off) {
                    await this.$vx.authRegister();
                }

            }
        }
    })
</script>