$(document).ready(function () {
  $(document).ready(main);
  /*input hover effect offline code
    $('.form-control').focus(function () {
    $(this).next('.label-brdr').css('width', '100%');
    })
    $('.form-control').focusout(function () {
    $(this).next('.label-brdr').css('width', '0%');
    })*/

  /*search bar open close */
  $(".search-nav").click(function () {
    $(".search-bar").slideToggle();
    $(".search-bar .form-control").focus();
  });

  /* Search Bar*/

  $(function () {
    $('input[type="radio"]').change(function () {
      $("#search-bar").slideUp(500);
      // if($(".btn-active input[value='1']:checked")){
      if ($("input[name=option]:checked").val() == "1") {
        $("#search-bar").slideDown(500);
      } else {
        $("#search-bar").slideUp(500);
      }

      if ($("input[name=option]:checked").val() == "0") {
        $("#search-bar-1").slideDown(500);
      } else {
        $("#search-bar-1").slideUp(500);
      }
    });
  });

  /*alert message*/
  $(".custom-alert .custom-close").click(function () {
    //$(this).parent('.custom-alert').addClass('slideOutUp').removeClass('slideInDown');
  });
  /*tooltip*/
  $('[data-toggle="tooltip"]').tooltip({
    //	template:'<div class="tooltip custom-tip animated slideInDown" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"> </div></div>'
  });
  /*radio status select*/
  if ($(".btn-status.btn-deactive input[type=radio]").prop("checked")) {
    $(".btn-status.btn-deactive").addClass("active");
  }
  if ($(".btn-status.btn-active input[type=radio]").prop("checked")) {
    $(".btn-status.btn-active").addClass("active");
  }
  /**/
});

/*input hover effect*/
function txtFocus(Inp) {
  $(Inp).next(".label-brdr").css("width", "100%");
  $(Inp).parent(".form-group").find("label").css("color", "#06b5ef");
}
function txtFocusOut(Inp) {
  $(Inp).next(".label-brdr").css("width", "0%");
  $(Inp).parent(".form-group").find("label").css("color", "#999");
}

/*full screen*/
function toggleFullScreen(elem) {
  // ## The below if statement seems to work better ## if ((document.fullScreenElement && document.fullScreenElement !== null) || (document.msfullscreenElement && document.msfullscreenElement !== null) || (!document.mozFullScreen && !document.webkitIsFullScreen)) {
  if (
    (document.fullScreenElement !== undefined &&
      document.fullScreenElement === null) ||
    (document.msFullscreenElement !== undefined &&
      document.msFullscreenElement === null) ||
    (document.mozFullScreen !== undefined && !document.mozFullScreen) ||
    (document.webkitIsFullScreen !== undefined && !document.webkitIsFullScreen)
  ) {
    if (elem.requestFullScreen) {
      elem.requestFullScreen();
    } else if (elem.mozRequestFullScreen) {
      elem.mozRequestFullScreen();
    } else if (elem.webkitRequestFullScreen) {
      elem.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
    } else if (elem.msRequestFullscreen) {
      elem.msRequestFullscreen();
    }
  } else {
    if (document.cancelFullScreen) {
      document.cancelFullScreen();
    } else if (document.mozCancelFullScreen) {
      document.mozCancelFullScreen();
    } else if (document.webkitCancelFullScreen) {
      document.webkitCancelFullScreen();
    } else if (document.msExitFullscreen) {
      document.msExitFullscreen();
    }
  }
}
