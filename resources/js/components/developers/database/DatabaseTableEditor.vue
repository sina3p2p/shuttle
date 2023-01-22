<template>
  <div class="row">
    <textarea hidden name="table" v-model="tableJson"></textarea>
    <div class="col-md-6">
      <label for="name">Table name</label><br />
      <input
        v-model.trim="table.name"
        type="text"
        class="form-control"
        required
      />
    </div>
    <div class="col-md-2">
      <label for="name">Table name</label><br />
      <switches></switches>
    </div>
    <div class="col-md-2">
      <label for="name">Table name</label><br />
      <switches></switches>
    </div>
    <div class="col-md-2 text-right">
      <br />
      <button class="btn btn-primary" type="button" @click="saveTable">
        Save
      </button>
    </div>
    <div class="col-12 mt-3">
      <table class="table table-bordered">
        <thead class="thead-light">
          <tr>
            <th>Name</th>
            <th>Type</th>
            <th>Length</th>
            <th>Default</th>
            <th>Unsigned</th>
            <th>Required</th>
            <th>A_I</th>
            <!-- <th>Index</th> -->
            <th></th>
          </tr>
        </thead>
        <tbody>
          <database-table-row
            v-for="(column, index) in table.columns"
            :key="index"
            v-model="table.columns[index]"
          ></database-table-row>
          <!-- <database-table-row
                v-for="(column, index) in table.columns"
                :column="column"
                :index="getColumnsIndex(column.name)"
                :key="index"
                @columnNameUpdated="renameColumn"
                @columnDeleted="deleteColumn"
                @indexAdded="addIndex"
                @indexDeleted="deleteIndex"
                @indexUpdated="updateIndex"
                @indexChanged="onIndexChange"
              ></database-table-row> -->
        </tbody>
      </table>
    </div>
    <div class="col-12 text-center">
      <button type="button" class="btn btn-success" @click="addNewColumn">
        + New Column
      </button>
      <button type="button" class="btn btn-success" @click="addTimestamps">
        + Add Timestamps
      </button>
      <button type="button" class="btn btn-success">+ Add Soft Deletes</button>
      <button type="button" class="btn btn-success">+ Add Translations</button>
      <!-- s
          <div class="btn btn-success" @click="addTimestamps">
            + Add Timestamps
          </div>
          <div class="btn btn-success" @click="addSoftDeletes">
            + Add Soft Deletes
          </div>
          <div class="btn btn-success" @click="addTranslations">
            + Add Translations
          </div> -->
    </div>
  </div>
  <!-- <div class="panel-body">
      <div class="row">
        <div class="col-md-6">
          <label for="name">Table name</label><br />
          <input
            id="name"
            v-model.trim="table.name"
            @input="tblNameChange"
            type="text"
            class="form-control"
            required
            pattern="{{ $db->identifierRegex }}"
          />
        </div>
        @if($db->action == 'create')
        <div class="col-md-3 col-sm-4 col-xs-6">
          <label for="create_model">Generate model?</label><br />
          <input
            type="checkbox"
            name="create_model"
            data-toggle="toggle"
            checked
          />
        </div>
        @else
        <div class="col-md-3 col-sm-4 col-xs-6">
          <label for="create_model">Update Scaffold?</label><br />
          <input
            type="checkbox"
            name="scaffold_update"
            data-toggle="toggle"
            checked
          />
        </div>
        @endif
      </div>

      <div v-if="compositeIndexes.length" v-once class="alert alert-danger">
        <p>{{ __("voyager::database.no_composites_warning") }}</p>
      </div>

      <div id="alertsContainer"></div>

      <template v-if="tableHasColumns">
        <table class="table table-bordered" style="width: 100%">
          <thead>
            <tr>
              <th>Column name</th>
              <th>Column type</th>
              <th>Length</th>
              <th>Require</th>
              <th>Unsigned</th>
              <th>Auto Increment</th>
              <th>Fillable</th>
              <th>Index</th>
              <th>Default</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <database-column
              v-for="(column, index) in table.columns"
              :column="column"
              :index="getColumnsIndex(column.name)"
              :key="index"
              @columnNameUpdated="renameColumn"
              @columnDeleted="deleteColumn"
              @indexAdded="addIndex"
              @indexDeleted="deleteIndex"
              @indexUpdated="updateIndex"
              @indexChanged="onIndexChange"
            ></database-column>
          </tbody>
        </table>
      </template>

      <div v-else>
        <p>{{ __("voyager::database.table_no_columns") }}</p>
      </div>

      <div style="text-align: center">
        <database-table-helper-buttons
          @columnAdded="addColumn"
          :isTranslatable="isTranslateModel"
          :tableName="table.name"
        ></database-table-helper-buttons>
      </div>
    </div>

    <div class="panel-footer">
      <input
        type="submit"
        class="btn btn-primary pull-right"
        value="Save"
        :disabled="!tableHasColumns"
      />
    </div> -->
</template>

<script>
import Switches from "vue-switches";

export default {
  components: {
    Switches,
  },
  props: {
    originalTable: {
      type: Object,
      required: false,
      default: () => ({}),
    },
    types: {
      type: Object,
      default: () => ({}),
    },
  },
  data() {
    return {
      table: {
        name: "",
        columns: [],
      },
      tableJson: "",
    };
  },
  mounted() {
    this.table = this.originalTable;
  },
  methods: {
    // addNewColumn() {
    //   this.table.columns.push({});
    // },
    addColumn(column) {
      this.table.columns.push(column);
    },
    makeColumn(options) {
      return $.extend(
        {
          name: "",
          oldName: "",
          type: {
            name: "bigint",
            category: "Numbers",
            default: {
              type: "number",
              step: "any",
            },
          },
          length: null,
          fixed: false,
          unsigned: false,
          autoincrement: false,
          notnull: false,
          default: null,
        },
        options
      );
    },
    addNewColumn() {
      this.addColumn(this.makeColumn());
    },
    addTimestamps() {
      this.addColumn(
        this.makeColumn({
          name: "created_at",
          type: "timestamp",
        })
      );

      this.addColumn(
        this.makeColumn({
          name: "updated_at",
          type: "timestamp",
        })
      );
    },
    addSoftDeletes() {
      this.addColumn(
        this.makeColumn({
          name: "deleted_at",
          type: "timestamp",
        })
      );
    },
    addTranslations() {
      this.addColumn(
        this.makeColumn({
          name: "locale",
          type: "varchar",
          length: 4,
        })
      );

      this.addColumn(
        this.makeColumn({
          name: this.tableName.replace("_translations", "_id"),
          type: "integer",
        })
      );
    },
    saveTable() {
      this.tableJson = JSON.stringify(this.table);

      this.$nextTick(() => this.$emit("submit"));
    },
  },
};
</script>
