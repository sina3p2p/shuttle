<template>
  <div>
    <div
      class="form-group"
      :key="`array-item-${input.field}-${input.id}`"
      v-for="input in inputs"
    >
      <label>{{ input.display_name }}</label>
      <image-input
        v-if="input.type == 'image'"
        :name="inputName(input)"
        :path="value[input.field]"
        :preview="
          value[input.field]
            ? value[input.field].replace('public', '/storage')
            : ''
        "
      ></image-input>
      <component
        v-else
        :is="componentName(input)"
        :name="inputName(input)"
        :value="value[input.field]"
      ></component>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    inputs: {
      type: Array,
      default: [],
    },
    value: {
      type: Object,
      default: {},
    },
    prefix: {
      type: String,
      default: "",
    },
  },
  methods: {
    componentName(input) {
      const componentName = `${_.camelCase(input.type)}Input`;
      return componentName[0].toUpperCase() + componentName.slice(1);
    },
    inputName(input) {
      if (this.prefix) return this.prefix + "[" + input.field + "]";

      return input.field;
    },
  },
};
</script>
