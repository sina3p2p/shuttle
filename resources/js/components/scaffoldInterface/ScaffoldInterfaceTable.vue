<template>
  <div class="page page_add">
    <div class="page-title">
      <div
        class="page-title__item"
        v-for="(c, index) in tableColumn"
        :key="'header-column-' + index"
      >
        {{ c.title }}
      </div>
    </div>
    <div class="page-content">
      <div class="page-content__item" v-for="(row, i) in res.data" :key="i">
        <div
          class="item-init"
          v-for="(c, index) in tableColumn"
          :key="'c-' + i + '-' + index"
          v-html="row[c.data]"
        ></div>
      </div>
    </div>
  </div>
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
  data() {
    return {
      res: {
        data: [],
      },
    };
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
    this.initTable();
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
    async initTable() {
      const me = this;
      this.res = await $.get(this.url);
      this.$nextTick(() => {
        me.onDraw();
      });
    },
    onDraw() {
      GLightbox({});
    },
  },
};
</script>
