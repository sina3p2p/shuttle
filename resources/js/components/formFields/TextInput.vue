<template>
  <input type="text" class="form-control" :name="name" :value="value" />
</template>

<script>
export default {
  props: {
    name: {
      type: String,
      default: "",
    },
    value: {
      type: String,
      default: "",
    },
  },
};
</script>
