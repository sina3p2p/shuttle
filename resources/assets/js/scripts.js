function loadStyle(href, callback) {
  for (var i = 0; i < document.styleSheets.length; i++) {
    if (document.styleSheets[i].href == href) {
      return;
    }
  }
  var head = document.getElementsByTagName("head")[0];
  var link = document.createElement("link");
  link.rel = "stylesheet";
  link.type = "text/css";
  link.href = href;
  if (callback) {
    link.onload = function() {
      callback();
    };
  }
  head.appendChild(link);
}
(function($) {
  if ($().dropzone) {
    Dropzone.autoDiscover = false;
  }
  // loadStyle("/css/admin/dore.light.blue.min.css", onStyleComplete);
  // function onStyleComplete() {

  var url = document.location.toString();
  if (url.match('#')) {
    $('.nav-item a[href="#' + url.split('#')[1] + '"]').tab('show');
  }

  setTimeout(onStyleCompleteDelayed, 300);
  // }
  function onStyleCompleteDelayed(fn) {
      $("body").dore();
  }
})(jQuery);
