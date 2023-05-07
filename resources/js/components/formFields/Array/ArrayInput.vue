<template>
  <div>
    <div class="row mb-2">
    
      <div class="title-compo">
        <h1>{{ row.display_name }}</h1>
        <button
          class="btn btn-primary btn-addd"
          type="button"
          @click="addArrayItem"
        >
    <svg width="800px" height="800px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><title></title> <g id="Complete"><g data-name="add" id="add-2"><g><line fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" x1="12" x2="12" y1="19" y2="5"></line> <line fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" x1="5" x2="19" y1="12" y2="12"></line></g></g></g></svg> ახლის დამატება
        </button>
      </div>
    </div>
    <div class="card mb-3" v-for="(item, key) in items" :key="`item-${key}`">
      <div class="card-body">
        <div class="title-of">
        <h5 class="mb-4">ITEM {{ key + 1 }}</h5>
        <button type="button" class="btn btn-danger" @click.prevent="removeItem(key)"><i class="simple-icon-trash"></i></button>
</div>
        <!-- /.title-of -->
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
