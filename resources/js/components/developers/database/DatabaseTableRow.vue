<template>
  <tr>
    <td>
      <input
        type="text"
        class="form-control"
        required
        v-model="columnData.name"
      />
    </td>

    <td>
      <database-type :column="columnData" v-model="columnData.type">
      </database-type>
    </td>

    <td>
      <input class="form-control" v-model="columnData.length" />
    </td>

    <td class="text-center">
      <select
        class="form-control"
        v-model="columnData.defaultType"
        @change="changeDefault"
      >
        <option value="">None</option>
        <option value="NULL">Null</option>
        <option value="DEFINED">As defined:</option>
      </select>

      <input
        class="form-control mt-1"
        v-model="columnData.default"
        v-if="showDefaultInput"
      />
    </td>
    <td class="text-center">
      <div class="form-check">
        <input
          class="form-check-input position-static"
          type="checkbox"
          value="option1"
          v-model="columnData.unsigned"
        />
      </div>
    </td>

    <td class="text-center">
      <div class="form-check">
        <input
          class="form-check-input position-static"
          type="checkbox"
          v-model="columnData.notnull"
          :disabled="columnData.defaultType == 'NULL'"
        />
      </div>
    </td>

    <td class="text-center">
      <div class="form-check">
        <input
          class="form-check-input position-static"
          type="checkbox"
          v-model="columnData.autoincrement"
        />
      </div>
    </td>
    <td>
      <button
        type="button"
        class="btn btn-bootstrap-padding btn-danger"
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
    value: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      columnData: {
        ...(this.value ?? {}),
        defaultType: "",
      },
    };
  },
  computed: {
    showDefaultInput() {
      return (
        this.columnData.defaultType == "DEFINED" || this.columnData.default
      );
    },
  },
  watch: {
    columnData: {
      handler(newValue) {
        this.$emit("input", newValue);
      },
      deep: true,
    },
  },
  mounted() {
    if (this.columnData.null == "YES" && this.columnData.default == null) {
      this.columnData.notnull = false;
      this.columnData.defaultType = "NULL";
    } else if (this.columnData.default) {
      this.columnData.defaultType = "DEFINED";
    } else {
      this.columnData.defaultType = "";
    }
  },
  methods: {
    deleteColumn() {
      this.$emit("columnDeleted", this.columnData);
    },
    changeDefault() {
      if (this.columnData.defaultType == "NULL") {
        this.columnData.notnull = false;
        this.columnData.default = null;
      } else if (this.columnData.defaultType == "") {
        this.columnData.default = null;
      }
    },
  },
};
</script>
