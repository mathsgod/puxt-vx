<template id="v-style">
    <el-card>
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
    </el-card>
</template>

<script>
    Vue.component("v-style", {
        template: document.getElementById("v-style"),
        data() {
            return {
                form: {}
            }
        },
        async created() {
            let {
                data
            } = await this.$vx.get("User/setting-style");
            this.form = data;

        },
        methods: {
            async submit() {
                let resp = await this.$vx.post("User/setting-style", this.form);

                if (resp.status == 204) {
                    this.$message.success("style updated");
                }
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

    function post(VX $vx)
    {
        $user = $vx->user;
        foreach ($vx->_post as $k => $v) {
            $user->style[$k] = $v;
        }
        $user->save();

        http_response_code(204);
    }

    function get(VX $vx)
    {
        $user = $vx->user;
        $style = $user->style ?? [];
        return $style;
    }
};
