<template>
  <tr>
    <td>
      <input type="text" class="form-control" required v-model="column.name" />
    </td>

    <td>
      <database-type :column="column" v-model="column.type"> </database-type>
    </td>

    <td>
      <input
        min="0"
        type="number"
        class="form-control"
        v-model="column.length"
      />
    </td>

    <td class="text-center">
      <!-- <div class="form-check">
        <input
          class="form-check-input position-static"
          type="checkbox"
          id="blankCheckbox"
          value="option1"
        />
      </div> -->
      <select
        class="form-control"
        v-model="column.defaultType"
        @change="changeDefault"
      >
        <option value="">None</option>
        <option value="null">Null</option>
        <option value="custom_default_value">As defined:</option>
      </select>

      <input class="form-control mt-1" v-if="showDefaultInput" />

      <!-- <div class="custom-control custom-checkbox">
        <input
          v-model="column.notnull"
          type="checkbox"
          class="custom-control-input"
          id="unsigned-checkbox"
        />
        <label class="custom-control-label" for="unsigned-checkbox"></label>
      </div> -->
    </td>
    <td class="text-center">
      <div class="form-check">
        <input
          class="form-check-input position-static"
          type="checkbox"
          value="option1"
          v-model="column.unsigned"
        />
      </div>
      <!-- <input
        v-model="column.unsigned"
        type="checkbox"
        class="custom-control-input"
      /> -->
    </td>

    <td class="text-center">
      <div class="form-check">
        <input
          class="form-check-input position-static"
          type="checkbox"
          v-model="column.nullable"
          :disabled="column.defaultType == 'null'"
        />
      </div>
      <!-- <input
        v-model="column.unsigned"
        type="checkbox"
        class="custom-control-input"
      /> -->
    </td>

    <td class="text-center">
      <div class="form-check">
        <input
          class="form-check-input position-static"
          type="checkbox"
          value="option1"
        />
      </div>
      <!-- <input
        v-model="column.autoincrement"
        type="checkbox"
        class="custom-control-input"
      /> -->
    </td>

    <!-- <td> -->
    <!-- <select class="form-control">
        <option value=""></option>
        <option value="INDEX">INDEX</option>
        <option value="UNIQUE">UNIQUE</option>
        <option value="PRIMARY">PRIMARY</option>
      </select> -->
    <!-- <select
        :value="index.type"
        @change="onIndexTypeChange"
        :disabled="column.type.notSupportIndex"
        class="form-control"
      >
        <option value=""></option>
        <option value="INDEX">INDEX</option>
        <option value="UNIQUE">UNIQUE</option>
        <option value="PRIMARY">PRIMARY</option>
      </select> -->
    <!-- <small v-if="column.composite" v-once>{{
        __("voyager::database.composite_warning")
      }}</small> -->
    <!-- </td> -->

    <!-- <td>
      <database-column-default :column="column"></database-column-default>
    </td> -->

    <td>
      <button
        type="button"
        class="btn btn-bootstrap-padding btn-xs btn-danger"
        @click.prevent="deleteColumn"
      >
        <i class="simple-icon-trash"></i>
      </button>
    </td>
  </tr>
</template>

<script>
export default {
  props: {
    column: {
      type: Object,
      required: true,
    },
  },
  computed: {
    showDefaultInput() {
      return (
        this.column.defaultType == "custom_default_value" || this.column.default
      );
    },
  },
  methods: {
    deleteColumn() {
      this.$emit("columnDeleted", this.column);
    },
    changeDefault() {
      if (this.column.defaultType == "null") {
        this.column.nullable = true;
      }
    },
  },
};
</script>
