$(document).ready(function () {
  var e = $(".video-widget"),
    a = document.getElementById("video-widget__video");
  $(".video-widget__close").click(function (t) {
    return (
      t.preventDefault(),
      "default" == e.attr("data-state")
        ? e.hide()
        : (e.attr("data-state", "default"), (a.muted = !0)),
      !1
    );
  }),
    $(".video-widget__container").on("click", function (t) {
      "default" == e.attr("data-state")
        ? (e.attr("data-state", "opened"), (a.currentTime = 0), (a.muted = !1))
        : (e.attr("data-state", "default"), (a.muted = !0));
    }),
    1024 < $(document).width() &&
      $(".video-widget__container").on("touchstart", function (t) {
        "default" == e.attr("data-state")
          ? (e.attr("data-state", "opened"),
            (a.currentTime = 0),
            (a.muted = !1))
          : (e.attr("data-state", "default"), (a.muted = !0));
      }),
    $(document).mouseup(function (t) {
      e.is(t.target) ||
        0 !== e.has(t.target).length ||
        "default" == e.attr("data-state") ||
        (e.attr("data-state", "default"), (a.muted = !0));
    });
});
