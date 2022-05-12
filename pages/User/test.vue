<template>
  <div>
    User test

    <div v-text="msg"></div>
    <el-button @click="test">Button</el-button>
    <router-link to="/User/test2">Home</router-link>
  </div>
</template>
<script>

export default {
  mounted() {
    //console.log(a);
  },
  data() {
    return {
      msg: "hello",
    };
  },
  methods: {
    test() {
      this.msg = "world";
    },
  },
};
</script>