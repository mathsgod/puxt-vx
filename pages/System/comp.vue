<template>
    <div>
        <el-card>
            card
        </el-card>

        <h1>System</h1>
        <h2>comp</h2>
        <el-input v-model="data"></el-input>
        {{ data }}

        <el-button @click="onClick" type="primary">Click me</el-button>
        <router-link to="/User/1/view">view</router-link>
        <router-link to="/System/comp">reload</router-link>
    </div>
</template>

<script>
export default {
    async setup() {
        let resp = await get('/System/test2');
        console.log(resp);

        return {
            a: 1
        };

    },
    data() {
        return {
            data: 'test'
        }
    },
    mounted() {

        console.log('mounted');
    }, methods: {
        onClick() {
            this.$message.success(this.data);
        }
    }
}
</script>