<template>
  <div>
    <div class="row mb-2">
      <div class="col-auto mr-auto align-self-center">
        <h4 class="mb-0">{{ row.display_name }}</h4>
      </div>
      <div class="col-auto">
        <button
          class="btn btn-primary btn-sm"
          type="button"
          @click="addArrayItem"
        >
          <i class="simple-icon-plus btn-group-icon"></i>
        </button>
      </div>
    </div>
    <div class="card mb-3" v-for="(item, key) in items" :key="`item-${key}`">
      <div class="card-body">
        <h5 class="mb-4">ITEM {{ key + 1 }}</h5>
        <button type="button" @click.prevent="removeItem(key)">DELETE</button>
        <array-item
          :prefix="`${name}[${key}]`"
          :inputs="inputs"
          :value="item"
        ></array-item>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    name: {
      type: String,
      default: "",
    },
    addItemUrl: {
      required: true,
      type: String,
    },
    inputs: {
      required: true,
      type: Array,
    },
    value: {
      type: Array,
      default: () => [],
    },
    row: {
      type: Object,
      default: () => ({}),
    },
  },
  data() {
    return {
      items: this.value ?? [],
    };
  },
  methods: {
    async addArrayItem() {
      this.items.push({});
    },
    removeItem(index) {
      this.items.splice(index, 1);
    },
  },
};
</script>
