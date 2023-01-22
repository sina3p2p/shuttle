<template>
  <select :value="column.type.name" @change="onTypeChange" class="form-control">
    <optgroup
      v-for="(types, category) in dbTypes"
      :key="category"
      :label="category"
    >
      <option v-for="type in types" :key="type.name" :value="type.name">
        {{ type.name.toUpperCase() }}
      </option>
    </optgroup>
  </select>
</template>

<script>
export default {
  props: {
    column: {
      type: Object,
      required: true,
    },
    value: {
      type: Object,
      default: null,
    },
  },
  //   data() {
  //     return {
  //       dbTypes: databaseTypes,
  //     };
  //   },
  computed: {
    dbTypes() {
      return window.dbTypes;
    },
  },
  methods: {
    onTypeChange(event) {
      this.$emit("input", this.getDbType(event.target.value));
    },
    getDbType(name) {
      let type;
      name = name.toLowerCase().trim();

      for (let category in this.dbTypes) {
        type = this.dbTypes[category].find(function (type) {
          return name == type.name.toLowerCase();
        });

        if (type) {
          return type;
        }
      }

      // toastr.error("{{ __('voyager::database.unknown_type') }}: " + name);

      return databaseTypes.Numbers[0];
    },
    getType(name) {
      return getDbType(name);
    },
  },
};
</script>
