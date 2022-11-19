<template>
  <table class="data-table data-table-feature"></table>
</template>

<script>
export default {
  props: {
    url: {
      required: true,
      type: String,
    },
    dataSrc: {
      required: false,
      type: String,
      default: "data",
    },
    columns: {
      required: true,
      type: Array,
    },
    selectable: {
      type: Boolean,
      default: false,
    },
    options: {
      type: Object,
      default: () => ({}),
    },
    className: {
      type: String,
      default: "",
    },
  },
  mounted() {
    const me = this;

    const columns = _.map(this.columns, (col) => ({
      orderable: false,
      title: "",
      data: null,
      className: me.className,
      render(data) {
        return data;
      },
      ...col,
    }));

    const props = this.$attrs;
    const opt = { ...this.options, ...props };

    if (this.selectable) {
      opt["select"] = {
        style: "multi",
      };
    }

    const $el = $(me.$el);
    const table = $el.DataTable({
      // dom: "lBfrtip",
      // buttons: [
      //   //   { extend: "csvHtml5", className: "btn-sm" },
      //   //   { extend: "excelHtml5", className: "btn-sm" },
      // ],
      // searchDelay: 1000,
      // searching: true,
      // processing: true,
      // deferRender: true,
      // serverSide: true,
      // // lengthMenu: caDatatable.getLengthMenu(),
      // // stateSave: true,
      // // pageLength: caDatatable.getLengthMenuDefault(),
      // order: [],
      // // language: caDatatable.getLanguageTranslations(),
      // dom: 'Bfrtip',
      sDom: '<"row view-filter mb-3"<"col-sm-12"<"float-right"l><"float-left d-flex"f<"filter-button">><"clearfix">>>t<"row view-pager"<"col-sm-12"<"text-center"ip>>>',
      buttons: [
        {
          text: "My button",
          action: function (e, dt, node, config) {
            alert("Button activated");
          },
        },
      ],
      columns: columns,
      drawCallback: function () {
        $($(".dataTables_wrapper .pagination li:first-of-type"))
          .find("a")
          .addClass("prev");
        $($(".dataTables_wrapper .pagination li:last-of-type"))
          .find("a")
          .addClass("next");

        $(".dataTables_wrapper .pagination").addClass("pagination-sm");
        $("div.filter-button").html(
          '<a href="#filters" class="btn btn-sm btn-primary ml-2"><i class="iconsminds-filter-2"></i></a>'
        );

        $el.css("width", "100%");
        me.$emit("draw");
      },
      language: {
        paginate: {
          previous: "<i class='simple-icon-arrow-left'></i>",
          next: "<i class='simple-icon-arrow-right'></i>",
        },
        search: "_INPUT_",
        searchPlaceholder: "Search...",
        lengthMenu: "Items Per Page _MENU_",
      },
      ajax: {
        url: me.url,
        dataSrc: me.dataSrc,
        headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        ...(props.ajax ?? {}),
      },
      processing: true,
      deferRender: true,
      serverSide: true,
      pageLength: 25,
      ...opt,
    });
    //   .on("draw", function () {
    //     // validationBootstrap.tooltipInit();
    //     $el.css("width", "100%");
    //     me.$emit("draw");
    //   });

    if (opt.select) {
      table
        .on("select", function () {
          me.$emit("select", table);
        })
        .on("deselect", function () {
          me.$emit("deselect", table);
        });
    }
  },
};
</script>

<style scoped>
@import "../../../assets/css/vendor/dataTables.bootstrap4.min.css";
@import "../../../assets/css/vendor/datatables.responsive.bootstrap4.min.css";
@import "../../../assets/css/parts/datatable.css";
</style>
