<template id="v-style">
    <el-card :header="$t('Style')">
        <el-form label-width="auto">
            <el-divider>Form</el-divider>
            <el-form-item label="Size">
                <el-select v-model="form.form_size" clearable>
                    <el-option value="large" label="large"></el-option>
                    <el-option value="medium" label="medium"></el-option>
                    <el-option value="small" label="small"></el-option>
                    <el-option value="mini" label="mini"></el-option>
                </el-select>
            </el-form-item>

    

            <el-divider>Button</el-divider>
            <el-form-item label="Size">
                <el-select v-model="form.button_size" clearable>
                    <el-option value="large" label="large"></el-option>
                    <el-option value="medium " label="medium"></el-option>
                    <el-option value="small" label="small"></el-option>
                    <el-option value="mini" label="mini"></el-option>
                </el-select>
            </el-form-item>

            <el-divider>Table</el-divider>
            <el-form-item label="Size">
                <el-select v-model="form.table_size" clearable>
                    <el-option value="large" label="large"></el-option>
                    <el-option value="medium " label="medium"></el-option>
                    <el-option value="small" label="small"></el-option>
                    <el-option value="mini" label="mini"></el-option>
                </el-select>
            </el-form-item>

            <el-form-item label="Border">
                <el-switch v-model="form.table_border"></el-switch>
            </el-form-item>

            <el-divider>Description</el-divider>

            <el-form-item label="Size">
                <el-select v-model="form.description_size" clearable>
                    <el-option value="large" label="large"></el-option>
                    <el-option value="medium " label="medium"></el-option>
                    <el-option value="small" label="small"></el-option>
                    <el-option value="mini" label="mini"></el-option>
                </el-select>
            </el-form-item>
            <el-form-item label="Border">
                <el-switch v-model="form.description_border"></el-switch>
            </el-form-item>


            <button type="submit" class="btn btn-primary mt-1 mr-1" @click.prevent="save" v-text="$t('Save changes')"></button>

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
            } = await this.$vx.get("setting-style");
            this.form = data;

        },
        methods: {
            async save() {
                let resp = await this.$vx.post("/User/setting-style", this.form);

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
