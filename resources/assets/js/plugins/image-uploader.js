/*
Plugin : Upload multi and single image
Version : 0.0.1
Description : drag and drop uploader :D
*/

var active_card_html =
  '<div class="selected-library-item sfl-selected-item"><div class="card d-flex flex-row media-thumb-container"><a class="d-flex align-self-center self-thumb-container"><img src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" alt="uploaded image" class="list-media-thumbnail responsive border-0 sfl-selected-item-image" /><input class="sfl-selected-item-input" hidden></a><div class="d-flex flex-grow-1 min-width-zero"><div class="card-body align-self-center d-flex flex-column justify-content-between min-width-zero align-items-lg-center"><a class="w-100"><p class="list-item-heading mb-1 truncate sfl-selected-item-label"></p></a></div><div class="pl-1 align-self-center"><a href="#" class="btn-link delete-library-item sfl-delete-item"><i class="simple-icon-trash"></i></a></div></div></div></div>';

var uploaded_file_card =
  '<li class="fileuploader-item file-type-image"><input class="hidden-input" hidden><div class="fileuploader-item-inner"><div class="actions-holder"><div class="fileuploader-action fileuploader-action-sort" title="Sort"><i class="fa fa-arrows"></i></div><button type="button" class="fileuploader-action fileuploader-action-remove" title="Delete"><i class="fa fa-close remove-image"></i></button></div><div class="thumbnail-holder"><div class="fileuploader-item-image"><img src="#" draggable="false"></div><div class="progress-holder" style="display: block;"><span>Uploading...</span><div class="fileuploader-progressbar"><div class="bar" style="height: 0;"></div></div></div></div></div></li>';

$.sinaUploader = function (element, options) {
  var plugin = this;
  var defaults = {
    // Sets how many items can be selected from library. Set to -1 disable selection limit.
    count: 1,

    // Modal id from which items will be selected
    libraryId: "#modal",

    // Submit button class in library modal.
    submitButtonClass: ".sfl-submit",

    // Container class for library item
    itemContainerClass: ".sfl-item-container",

    // Selected item template class
    selectedItemClass: ".sfl-selected-item",

    // Selected item template class to distinction
    selectedItemClassActive: ".sfl-selected-item-active",

    // Selected item template image class
    selectedItemImageClass: ".sfl-selected-item-image",

    // Selected item template image class
    selectedItemInputClass: ".sfl-selected-item-input",

    // Selected item template label class
    selectedItemLabelClass: ".sfl-selected-item-label",

    // Selected item delete class
    selectedItemDeleteClass: ".sfl-delete-item",

    // Media Container
    selectedMediaContainerClass: ".self-thumb-container",

    // Video Formats
    videosFormat: [
      "mp4",
      "m4a",
      "m4v",
      "f4v",
      "f4a",
      "m4b",
      "m4r",
      "f4b",
      "mov",
      "3gp",
      "3gp2",
      "3g2",
      "3gpp",
      " 3gpp2",
      "ogg",
      "oga",
      "ogv",
      "ogx",
    ],

    inputSelector: "input[type=file]",

    selectedItemHtml: active_card_html,
  };

  let $self = $(element);

  let $newEl = $(
    '<div class="fileuploader file-main-1 fileuploader-theme-gallery"><input type="file" multiple="multiple" style="position: absolute; z-index: -9999; height: 0; width: 0; padding: 0; margin: 0; line-height: 0; outline: 0; border: 0; opacity: 0;"><div class="fileuploader-items"><ul class="fileuploader-items-list" id="sortable"><li class="fileuploader-input"><button type="button" class="fileuploader-input-inner"><i class="fileuploader-icon-main"></i> <span>Drag &amp; Drop</span></button></li></ul></div></div>'
  );

  plugin.settings = $.extend({}, defaults, options, $self.data());

  $self.replaceWith($newEl);

  var $input = $newEl.find(plugin.settings.inputSelector);

  var multiple = $self.is("[multiple]");

  var name = $self.attr("name");

  if (multiple) {
    $newEl.find("#sortable").sortable({
      handle: ".fileuploader-action-sort",
      items: "li:not(li:first-child)",
      placeholder:
        "fileuploader-item file-main-1 fileuploader-sorter-placeholder",
    });
  }

  $newEl.find("button.fileuploader-input-inner").on("click", function (e) {
    e.preventDefault();
    $input.click();
  });

  $input.on("change", function (e) {
    e.preventDefault();
    if (this.files) {
      let files = this.files;
      if (multiple) {
        for (let i = 0; i < files.length; i++) {
          upload(files[i]);
        }
      } else {
        $newEl.find("li.fileuploader-input").hide();
        upload(files[0]);
      }
    }
  });

  function upload(file) {
    var fd = new FormData();
    fd.append("file", file);
    var previewItem = $(uploaded_file_card);
    var progressBar = previewItem.find(".bar");
    $.ajax({
      url: "/mypanel/media/upload",
      type: "post",
      headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
      data: fd,
      contentType: false,
      processData: false,
      xhr: function () {
        var myXhr = $.ajaxSettings.xhr();
        if (myXhr.upload) {
          myXhr.upload.addEventListener(
            "progress",
            function (e) {
              if (e.lengthComputable) {
                var max = e.total;
                var current = e.loaded;
                var Percentage = (current * 100) / max;
                progressBar.height(Percentage + "%");
              }
            },
            false
          );
        }
        return myXhr;
      },
      beforeSend() {
        $newEl.find("ul.fileuploader-items-list").append(previewItem);
      },
      success: function (response) {
        syncElement(previewItem, response);
      },
    });
  }

  if ($self.data("value")) {
    var value = $self.data("value");
    if (multiple) {
      value.split(",").forEach(function (e) {
        var previewItem = $(uploaded_file_card);
        $newEl.find("ul.fileuploader-items-list").append(previewItem);
        syncElement(previewItem, {
          url: e.replace("public", "/storage"),
          path: e,
        });
      });
    } else {
      var previewItem = $(uploaded_file_card);
      $newEl.find("li.fileuploader-input").hide();
      $newEl.find("ul.fileuploader-items-list").append(previewItem);
      syncElement(previewItem, {
        url: value.replace("public", "/storage"),
        path: value,
      });
    }
  }

  function syncElement($el, config) {
    if (!multiple) {
      $el.find(".fileuploader-action-sort").remove();
    }
    $el.find("img").attr("src", config.url);
    $el
      .find(".fileuploader-action-remove")
      .addClass("fileuploader-action-success")
      .removeClass("fileuploader-action-remove");
    $el.find("i.remove-image").addClass("fa-check").removeClass("fa-close");
    $el.find("input.hidden-input").val(config.path).attr("name", name);
    $el.find(".fileuploader-action-success").on("click", function (e) {
      e.preventDefault();
      $(this).parents(".fileuploader-item").remove();
      $newEl.find("li.fileuploader-input").show();
    });
    $el.find(".progress-holder").hide();
  }

  var $modal =
    plugin.settings.libraryId.indexOf("#") > -1
      ? $(plugin.settings.libraryId)
      : $("#" + plugin.settings.libraryId);
  var $itemContaines;
  var $submitButton;
  var $submitButtonLabel;
  var $checkedItems;
  var selectedItems;

  if (plugin.settings.previewPath && plugin.settings.path) {
    $checkedItems = $(
      "<div data-preview-path='" +
        plugin.settings.previewPath +
        "' data-path='" +
        plugin.settings.path +
        "' data-label='" +
        plugin.settings.path +
        "'/>"
    );
    onSubmitHandler(null);
    hideSelectButton();
  }

  function init() {
    $itemContaines = $(plugin.settings.itemContainerClass);
    $submitButton = $modal.find(plugin.settings.submitButtonClass);
    $submitButtonLabel = $submitButton.html();
    clearAllSelections();
    $modal.modal($modal.data());
    // if (plugin.settings.count == 1) {
    //   hideCheckboxes();
    // } else {
    //   showCheckboxes();
    // }
    $submitButton.on("click", onSubmitHandler);
    // $modal.on(
    //   "change",
    //   plugin.settings.itemContainerClass + " .custom-control-input",
    //   checkChange
    // );
    $(document).on(
      "change",
      plugin.settings.itemContainerClass + " .custom-control-input",
      checkChange
    );
    $modal.on("hidden.bs.modal", onModalHide);
    $("#dpz-multiple-files").dropzone({
      url: $(this).data("url"),
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
      },
      success: function (file, response) {
        var item =
          $(`<div class="col-6 pl-2 pr-2 mb-1 sfl-item-container" data-preview-path="${response.url}" data-path="${response.path}" data-label="${file.name}">
                          <div class="card d-flex mb-2 p-0 media-thumb-container">
                              <div class="d-flex align-self-stretch"><img src="${response.url}" alt="uploaded image" class="list-media-thumbnail responsive border-0" /></div>
                              <div class="d-flex flex-grow-1 min-width-zero">
                                  <div class="card-body pr-1 pt-2 pb-2 align-self-center d-flex min-width-zero"> <div class="w-100"><p class="truncate mb-0">${file.name}</p></div></div>
                                  <div class="custom-control custom-checkbox pl-1 pr-1 align-self-center">
                                      <label class="custom-control custom-checkbox mb-0">
                                          <input type="checkbox" class="custom-control-input"><span class="custom-control-label"></span>
                                      </label></div></div></div></div>`);
        $modal.find(".list .row").append(item);
        this.removeFile(file);
      },
      thumbnailWidth: 160,
      timeout: 180000,
      previewTemplate:
        '<div class="dz-preview dz-file-preview mb-3"><div class="d-flex flex-row "><div class="p-0 w-30 position-relative"><div class="dz-error-mark"><span><i class="simple-icon-exclamation"></i>  </span></div>      <div class="dz-success-mark"><span><i class="simple-icon-check-circle"></i></span></div><img data-dz-thumbnail class="img-thumbnail border-0" /> </div><div class="pl-3 pt-2 pr-2 pb-1 w-70 dz-details position-relative"> <div> <span data-dz-name /> </div> <div class="text-primary text-extra-small" data-dz-size /> </div> <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div><div class="dz-error-message"><span data-dz-errormessage></span></div></div><a href="#" class="remove" data-dz-remove><i class="simple-icon-trash"></i></a></div>',
    });
  }

  $self.on("click", function (event) {
    event.preventDefault();
    init();
  });

  function checkChange(event) {
    $checkedItems = $(
      plugin.settings.itemContainerClass + " .custom-control-input:checked"
    ).parents(plugin.settings.itemContainerClass);
    if (plugin.settings.count == 1) {
      onSubmitHandler(null);
      hideSelectButton();
      return;
    }
    $submitButton.html(
      $checkedItems.length > 0
        ? $submitButtonLabel + " (" + $checkedItems.length + ")"
        : $submitButtonLabel
    );
  }

  function onSubmitHandler(event) {
    event && event.preventDefault();
    getDataFromDomItems($checkedItems);
    appendSelectedItems();
    $modal.modal("hide");
  }

  function appendSelectedItems() {
    var $emptyParent;
    var $itemTemp;
    var $grandParent = $self.parent().parent();
    var videosFormat = plugin.settings.videosFormat;
    for (var i = 0; i < selectedItems.length; i++) {
      $emptyParent = $self.parent().clone().empty();
      $itemTemp = $(plugin.settings.selectedItemHtml); //$self.parent().find(plugin.settings.selectedItemClass).clone();
      var fileFormat = selectedItems[i].previewPath.split(".").pop();
      if (videosFormat.indexOf(fileFormat) !== -1) {
        $itemTemp
          .find(plugin.settings.selectedMediaContainerClass)
          .html(
            '<a class="d-flex align-self-center"><video src="' +
              selectedItems[i].previewPath +
              '" class="list-media-thumbnail responsive border-0 sfl-selected-item-image" muted></video><input class="sfl-selected-item-input" name="' +
              plugin.settings.name +
              '" value="' +
              selectedItems[i].path +
              '" hidden></a>'
          );
      } else {
        $itemTemp
          .find(plugin.settings.selectedItemImageClass)
          .attr("src", selectedItems[i].previewPath);
        $itemTemp
          .find(plugin.settings.selectedItemInputClass)
          .attr("name", plugin.settings.name);
        $itemTemp
          .find(plugin.settings.selectedItemInputClass)
          .val(selectedItems[i].path);
      }
      $itemTemp
        .find(plugin.settings.selectedItemLabelClass)
        .html(selectedItems[i].label);
      $itemTemp.css("display", "block");
      $itemTemp.addClass(
        plugin.settings.selectedItemClassActive.replace(".", "")
      );
      $emptyParent.append($itemTemp);
      $grandParent.prepend($emptyParent);
      $itemTemp
        .find(plugin.settings.selectedItemDeleteClass)
        .on("click", onDeleteClick);
      for (var prop in selectedItems[i]) {
        $itemTemp.data(prop, selectedItems[i][prop]);
      }
    }
  }

  function onDeleteClick(event) {
    event.preventDefault();
    $(this)
      .parents(plugin.settings.selectedItemClass)
      .off("click", plugin.settings.selectedItemDeleteClass, onDeleteClick);
    $(this).parents(plugin.settings.selectedItemClass).parent().remove();
    updateSelectedItemsByDom();
    if (plugin.settings.count == 1) {
      showSelectButton();
    }
  }

  function updateSelectedItemsByDom() {
    var $grandParent = $self.parent().parent();
    var $items = $grandParent.find(plugin.settings.selectedItemClassActive);
    getDataFromDomItems($items);
  }

  function getDataFromDomItems($items) {
    selectedItems = [];
    if (!$items) {
      return;
    }
    $items.each(function () {
      selectedItems.push($(this).data());
    });
  }

  function onModalHide(event) {
    $submitButton.html($submitButtonLabel);
    $submitButton.off("click", onSubmitHandler);
    $(document).off(
      "change",
      plugin.settings.itemContainerClass + " .custom-control-input",
      checkChange
    );
    // $modal.off(
    //   "change",
    //   plugin.settings.itemContainerClass + " .custom-control-input",
    //   checkChange
    // );
    $modal.off("hidden.bs.modal", onModalHide);
  }

  function hideCheckboxes() {
    $itemContaines.each(function () {
      $(this)
        .find(".custom-checkbox")
        // .css("visibility", "hidden");
        .css("display", "none");
    });
  }

  function showCheckboxes() {
    $itemContaines.each(function () {
      $(this)
        .find(".custom-checkbox")
        // .css("visibility", "visible");
        .css("display", "block");
    });
  }

  function clearAllSelections() {
    $itemContaines.each(function () {
      $(this).find(".custom-control-input").prop("checked", false);
      $(this).find(".active").removeClass("active");
    });
  }

  function hideSelectButton() {
    // $self.css("visibility", "hidden");
    $self.css("display", "none");
  }

  function showSelectButton() {
    // $self.css("visibility", "visible");
    $self.css("display", "block");
  }

  plugin.getData = function () {
    return selectedItems || [];
  };
};

$.fn.sinaUploader = function (options) {
  return this.each(function () {
    if (undefined === $(this).data("sinaUploader")) {
      var plugin = new $.sinaUploader(this, options);
      $(this).data("selectFromLibrary", plugin);
    }
  });
};
