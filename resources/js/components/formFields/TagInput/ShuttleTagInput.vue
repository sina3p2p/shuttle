<template>
  <input
    v-if="scope.edit"
    v-model="scope.tag.text"
    :maxlength="scope.maxlength"
    type="text"
    class="ti-tag-input"
    size="1"
    :name="name"
    @input="scope.validateTag(scope.index, $event)"
    @blur="scope.performCancelEdit(scope.index)"
    @keydown="scope.performSaveEdit(scope.index, $event)"
  />
</template>

<script>
export default {
  props: {
    scope: {
      type: Object,
    },
    name: {
      type: String,
      default: "",
    },
  },
};
</script>

<style lang="css" scoped>
.ti-tag-input {
  background-color: transparent;
  color: inherit;
  border: none;
  padding: 0px;
  margin: 0px;
  display: flex;
  top: 0px;
  position: absolute;
  width: 100%;
  line-height: inherit;
}
.ti-tag-input::-ms-clear {
  display: none;
}
input:focus {
  outline: none;
}
input[disabled] {
  background-color: transparent;
}
</style>
