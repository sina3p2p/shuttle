<template>
  <ul>
    <button @click.prevent="$emit('on-add-click', item)">Add</button>
    <li v-for="(object, objIndex) in item.children" :key="objIndex">
      <input
        :name="'data[' + index + '][object][' + objIndex + '][field]'"
        v-model="object.field"
      />
      <select
        :name="'data[' + index + '][object][' + objIndex + '][type]'"
        v-model="object.type"
      >
        <option v-for="(type, tIndex) in inputTypes" :key="tIndex">
          {{ type }}
        </option>
      </select>
      <component-tab-data-array
        v-if="object.type == 'array'"
        :item="object"
        :index="objIndex"
        @on-add-click="addClick"
        @on-remove-click="removeClick"
      ></component-tab-data-array>
      <input v-else v-model="object.display_name" />
      <button @click.prevent="$emit('on-remove-click', item, objIndex)">
        Remove
      </button>
    </li>
  </ul>
</template>

<script>
import { store } from "./mixin";

export default {
  props: ["item", "index"],
  data() {
    return {
      inputTypes: store.state.types,
    };
  },
  methods: {
    addClick(obj) {
      this.$emit("on-add-click", obj);
    },
    removeClick(obj, key) {
      this.$emit("on-remove-click", obj, key);
    },
  },
};
</script>
