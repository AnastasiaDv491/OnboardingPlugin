console.log("hello");

(function ($) {

  /**
   * Copyright 2012, Digital Fusion
   * Licensed under the MIT license.
   * http://teamdf.com/jquery-plugins/license/
   *
   * @author Sam Sehnert
   * @desc A small plugin that checks whether elements are within
   *     the user visible viewport of a web browser.
   *     only accounts for vertical position, not horizontal.
   */

  $.fn.visible = function (partial) {

    var $t = $(this),
      $w = $(window),
      viewTop = $w.scrollTop(),
      viewBottom = viewTop + $w.height(),
      _top = $t.offset().top,
      _bottom = _top + $t.height(),
      compareTop = partial === true ? _bottom : _top,
      compareBottom = partial === true ? _top : _bottom;

    return ((compareBottom <= viewBottom) && (compareTop >= viewTop));

  };

})(jQuery);

//   document.addEventListener('scroll', function (event) {
//       console.log("gf");
// 	jQuery(function ($) { $(".timeline-item").each(function(i, el) {
//               var el = $(el);
//               //el.visible(true)
// 			  if (isInViewport(el)) {
// 				el.addClass("come-in"); 
// 			  } 
// 			  else{
// 				//   el.removeClass("come-in");
// 			  }
// 			});

// })}, true /*Capture event*/);

document.addEventListener('scroll', function () {
  const timelineItems = document.querySelectorAll(".timeline-item");
  for (var i = 0; i < timelineItems.length; i++) {
    //    console.log(isInViewport( timelineItems[i]));

    if (howMuchVisible(timelineItems[i], 1)) {
      timelineItems[i].classList.add('come-in');
    }
  }

}, {
  passive: true
});


function isInViewport(el) {
  // console.log(el);
  const rect = el.getBoundingClientRect();
  return (
    rect.top >= 0 &&
    rect.left >= 0 &&
    rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
    rect.right <= (window.innerWidth || document.documentElement.clientWidth)

  );
}

function howMuchVisible(el, percentVisible) {
  let
    rect = el.getBoundingClientRect(),
    windowHeight = (window.innerHeight || document.documentElement.clientHeight);

  return !(
    Math.floor(100 - (((rect.top >= 0 ? 0 : rect.top) / +-(rect.height / 1)) * 100)) < percentVisible ||
    Math.floor(100 - ((rect.bottom - windowHeight) / rect.height) * 100) < percentVisible
  )
};

jQuery(function ($) {
  $(document).ready(function () {
    //set initial state.

    $('#chkbx').change(function () {
    
      ajaxData = {
        _ajax_nonce: my_ajax_object.nonce, //nonce
        action: "stagetest",      //action
        status:   $(this).prop('checked'),
        timeline: "MBA"
      }


      jQuery.ajax({
        type: "post",
        dataType: "json",
        url: my_ajax_object.ajax_url,
        data: ajaxData,
        success: function (response, status, xhr) {
          if (response != "") {
            console.log(response);
            console.log(status);
            console.log("Response received");
          } else {
            alert("Invalid Data.");
          }
        }
        // error: function(msg){
        //   console.log(msg);
        // }
      });

    });
  });
});