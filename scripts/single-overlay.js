$(function() {
  var target;
  var title = $('.js-single-overlay-title');
  var image = $('.js-single-overlay-image');
  var caption = $('.js-single-overlay-caption');
  var nextButton = $('.js-single-overlay-next');
  var prevButton = $('.js-single-overlay-prev');
  var descButton = $('.js-single-desc');

  // init script
  bindEvents();

  // component logic
  function bindEvents() {
    $('.js-init-single-overlay').on('click', openSingleOverlay);
    $('.js-single-overlay-close').on('click', closeSingleOverlay);
    nextButton.on('click', nextOverlay);
    prevButton.on('click', prevOverlay);
    descButton.hover(showCaption, hideCaption);
  }

  function openSingleOverlay() {
    target = $(this);

    $('body').addClass('js-has-overlay');

    setOverlayContent();
  }

  function closeSingleOverlay() {
    $('body').removeClass('js-has-overlay');
  }

  function nextOverlay() {
    target = target.next();

    setOverlayContent();
  }

  function prevOverlay() {
    target = target.prev();

    setOverlayContent();
  }

  function setOverlayContent() {
    renderProgressButtons();
    renderDescriptionButton();

    title.text(target.data('title') || "");
    caption.text(target.data('caption') || "");
    image.attr('src', target.data('image-src'));
  }

  function renderProgressButtons() {
    if (target.next().length > 0) {
      nextButton.removeClass('js-is-hidden');
    } else {
      nextButton.addClass('js-is-hidden');
    }

    if (target.prev().length > 0) {
      prevButton.removeClass('js-is-hidden');
    } else {
      prevButton.addClass('js-is-hidden');
    }
  }

  function renderDescriptionButton() {
    if (target.data('caption') && target.data('caption') !== "") {
      descButton.removeClass('js-is-hidden');
    } else {
      descButton.addClass('js-is-hidden');
    }
  }

  function showCaption() {
    caption.removeClass('js-is-hidden');
  }

  function hideCaption() {
    caption.addClass('js-is-hidden');
  }
}());
