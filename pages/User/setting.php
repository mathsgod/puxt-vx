<?php
include_once(__DIR__ . "/setting-general.php");
include_once(__DIR__ . "/setting-change-password.php");
include_once(__DIR__ . "/setting-information.php");
include_once(__DIR__ . "/setting-style.php");
include_once(__DIR__ . "/setting-2step.php");
include_once(__DIR__ . "/setting-bio-auth.php");
?>

<div id="div1">
    <el-row :gutter="25">
        <el-col :md="6">
            <vx-nav v-model="selected" pills class="flex-column nav-left">
                <vx-nav-item index="v-general" icon="fa fa-user fa-fw">General</vx-nav-item>
                <vx-nav-item index="v-change-password" icon="fa fa-key fa-fw">{{'Change Password'|trans}}</vx-nav-item>
                <vx-nav-item index="v-information" icon="fa fa-info fa-fw">{{'Information'|trans}}</vx-nav-item>
                <vx-nav-item index="v-style" icon="fa fa-brush fa-fw">{{'Style'|trans}}</vx-nav-item>
                {% if two_step_verification %}
                <vx-nav-item index="v-2step" icon="fa fa-lock fa-fw">{{'2 Step verification'|trans}}</vx-nav-item>
                {% endif %}
                {% if biometric_authentication %}
                <vx-nav-item index="v-bio-auth" icon="fa fa-fingerprint fa-fw">{{'Biometric authentication'|trans}}</vx-nav-item>
                {% endif %}
            </vx-nav>
        </el-col>

        <el-col :md="18">
            <component :is="selected"></component>
        </el-col>
    </el-row>
</div>

<script>
    new Vue({
        el: "#div1",
        i18n,
        data() {
            return {
                selected: "v-general",
            }
        }
    });
</script>

<?php

return new class
{

    function get(VX $vx)
    {
        $config = $vx->config["VX"];
        $this->two_step_verification = boolval($config["two_step_verification"]);
        $this->biometric_authentication = boolval($config["biometric_authentication"]);
    }


};
