<template>
  <div>
    <input type="checkbox" v-model="fromDatabase" /> Load data from database
    <button @click.prevent="addRow">Add</button>
    <ul>
      <textarea name="myData" hidden>{{ myData }}</textarea>
      <li v-for="(item, index) in data" :key="index">
        <input :name="'data[' + index + '][field]'" v-model="item.field" />
        <select :name="'data[' + index + '][type]'" v-model="item.type">
          <option v-for="(type, tIndex) in types" :key="tIndex">
            {{ type }}
          </option>
        </select>
        <input v-model="item.display_name" />
        <component-tab-data-array
          v-if="item.type == 'array'"
          :item="item"
          :index="index"
          @on-add-click="addObjectToData"
          @on-remove-click="removeObjectFromData"
        ></component-tab-data-array>
        <div v-if="item.type == 'c_relationship'">
          type:
          <input
            @input="update(item.details, 'type', $event)"
            :value="item.details.type"
          />
          key:
          <input
            @input="update(item.details, 'key', $event)"
            :value="item.details.key"
          />
          label:
          <input
            @input="update(item.details, 'label', $event)"
            :value="item.details.label"
          />
          column:
          <input
            @input="update(item.details, 'column', $event)"
            :value="item.details.column"
          />
          model:
          <input
            @input="update(item.details, 'model', $event)"
            :value="item.details.model"
          />
          scope:
          <input
            @input="update(item.details, 'scope', $event)"
            :value="item.details.scope"
          />
        </div>
        <button @click.prevent="removeRow(index)">Remove</button>
      </li>
    </ul>
    <div v-if="fromDatabase">
      <textarea name="myModelData">{{ myModelData }}</textarea>
      <!-- <select v-model="model.name">
        @foreach(getModels() as $m)
        <option value="{{$m}}">{{ $m }}</option>
        @endforeach
      </select> -->
      <button @click.prevent="addModelRow">Add</button>
      <ul>
        <li v-for="(item, index) in model.conditions" :key="index">
          <input v-model="item.field" />
          <input v-model="item.type" />
          <input v-model="item.display_name" />
          <button @click.prevent="removeModelRow(index)">Remove</button>
        </li>
      </ul>
      <input v-model="model.name" />
      <input v-model="model.order" />
      <input v-model="model.scope" />
      <input v-model="model.limit" />
    </div>
  </div>
</template>

<script>
import { store } from "./mixin";

export default {
  props: {
    rows: {
      type: Array,
      value: [],
    },
    modelSetting: {
      type: Object,
      default: () => ({}),
    },
  },
  computed: {
    myData() {
      return JSON.stringify(this.data);
    },
    myModelData() {
      return JSON.stringify(this.model);
    },
  },
  data() {
    return {
      fromDatabase: this.modelSetting ? true : false,
      types: store.state.types,
      model: this.modelSetting ?? {},
      data: this.rows,
    };
  },
  methods: {
    update(obj, prop, event) {
      Vue.set(obj, prop, event.target.value);
    },
    addRow() {
      this.data.push({
        field: "",
        type: "text",
        display_name: "",
        details: {},
        children: [],
      });
    },
    addModelRow() {
      this.model.conditions.push({
        field: "",
        type: "where",
        display_name: "",
      });
    },
    removeModelRow(key) {
      this.model.conditions.splice(key, 1);
    },
    removeRow(key) {
      this.data.splice(key, 1);
    },
    removeObjectFromData(obj, key2, key) {
      obj.children.splice(key2, 1);
    },
    addObjectToData(obj) {
      obj.children.push({
        field: "",
        type: "text",
        children: [],
        display_name: "",
      });
    },
    showResult() {
      console.log(this.model);
    },
    getDefaultModelSetting() {
      return this.modelSetting
        ? JSON.parse(this.modelSetting).model
        : {
            name: "",
            order: "",
            conditions: [],
            limit: 0,
          };
    },
  },
};
</script>
