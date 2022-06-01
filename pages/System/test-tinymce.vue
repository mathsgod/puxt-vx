<template>
  <div>
    <vx-tinymce v-model="content"></vx-tinymce>
  </div>
</template>

<script>
export default {
  data() {
    return {
      content: "hello world",
    };
  },
};
</script>