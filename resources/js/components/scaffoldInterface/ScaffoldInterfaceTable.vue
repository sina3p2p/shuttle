<template>
  <ajax-table
    :url="url"
    :columns="tableColumn"
    class-name="text-nowrap"
    @draw="onDraw"
  ></ajax-table>
</template>

<script>
import GLightbox from "glightbox";

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
    deleteRoute: {
      type: String,
      default: "",
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
  mounted() {
    const $this = this;
    $(document).on("mousedown", ".remove-item", function (e) {
      e.preventDefault();
      $this.$root.$refs.confirm.open({
        message: "Are you sure?",
        button: {
          no: "No",
          yes: "Yes",
        },
        callback: (confirm) => {
          if (confirm) {
            var item = $(e.target);
            console.log(item.data("id"), $this.deleteRoute);
            var form = $(
              '<form action="' +
                $this.deleteRoute.replace("__id", item.data("id")) +
                '" method="post">' +
                '<input type="hidden" name="_token" value="' +
                $('meta[name="csrf-token"]').attr("content") +
                '" hidden>' +
                '<input name="_method" value="DELETE" />' +
                "</form>"
            );
            form.appendTo("body");
            form.submit();
          }
        },
      });
    });
  },
  methods: {
    onDraw() {
      GLightbox({});
    },
  },
};
</script>
