$(function() {
  var animDuration = 250;
  var marginOffset = 30;
  var curDist;
  var animating = false;
  var imageList = $('.js-image-list');
  var nextButton = $('.js-horizontal-next');
  var prevButton = $('.js-horizontal-prev');

  // init
  bindEvents();
  $('.js-theme-wrapper').addClass('horizontal-album');

  var testImageLoop = setInterval(function() {
    if (imageList.children()[0].complete) {
      setupFirstImage();
      clearInterval(testImageLoop);
    }
  }, 100);

  // component logic
  function setupFirstImage() {
    $(imageList.children()[0]).addClass('js-horizontal-current');
    curDist = 0;

    prevButton.addClass('js-is-hidden');
    nextButton.removeClass('js-is-hidden');
    imageList.animate({ 'margin-left': curDist }, animDuration);
  }

  function bindEvents() {
    nextButton.on('click', advanceNext);
    prevButton.on('click', advancePrev);
    $(window).resize(_.debounce(handleWindowResize, 200));
  }

  function advanceNext() {
    var targetDist;
    var currentImage = $('.js-horizontal-current');
    var nextImage = currentImage.next();
    var toLastImage = nextImage.next().length === 0;
    var offset = ($(window).width() - nextImage.width()) / 2;

    if (animating || nextImage.length === 0) return;

    curDist += currentImage.width() + marginOffset;

    if (toLastImage) {
      targetDist = -curDist + (offset * 2);
    } else {
      targetDist = offset - curDist;
    }

    animating = true;
    imageList.animate({ 'margin-left': targetDist }, animDuration, function() {
      animating = false;

      currentImage.removeClass('js-horizontal-current');
      nextImage.addClass('js-horizontal-current');

      showHideImageControls(!toLastImage, true);
    });
  }

  function advancePrev() {
    var currentImage = $('.js-horizontal-current');
    var prevImage = currentImage.prev();
    var offset = ($(window).width() - prevImage.width()) / 2;
    var toFirstImage = prevImage.prev().length === 0;

    if (animating || prevImage.length === 0) return;

    curDist -= prevImage.width() + marginOffset;

    if (toFirstImage) {
      targetDist = curDist;
    } else {
      targetDist = offset - curDist;
    }

    animating = true;
    imageList.animate({ 'margin-left': targetDist }, animDuration, function() {
      animating = false;

      currentImage.removeClass('js-horizontal-current');
      prevImage.addClass('js-horizontal-current');

      showHideImageControls(true, !toFirstImage);
    });
  }

  function handleWindowResize() {
    // reset to first image mode
    $('.js-horizontal-current').removeClass('js-horizontal-current');
    setupFirstImage();
  }

  function showHideImageControls(next, prev) {
    if (next) {
      nextButton.removeClass('js-is-hidden');
    } else {
      nextButton.addClass('js-is-hidden');
    }

    if (prev) {
      prevButton.removeClass('js-is-hidden');
    } else {
      prevButton.addClass('js-is-hidden');
    }
  }
}());
