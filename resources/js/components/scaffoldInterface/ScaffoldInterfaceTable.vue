<template>
  <ajax-table
    :url="url"
    :columns="tableColumn"
    class-name="text-nowrap"
  ></ajax-table>
</template>

<script>
export default {
  props: {
    columns: {
      type: Array,
      default: [],
    },
    url: {
      required: true,
      type: String,
    },
  },
  computed: {
    tableColumn() {
      return [
        ...this.columns,
        {
          title: "",
          className: "text-nowrap text-right",
          data: "action",
        },
      ];
    },
  },
};
</script>
