$(function() {
  var grid = $('.js-grid').masonry({
    itemSelector: '.js-grid-item',
    gutter: 20,
    fitWidth: true,
  });

  grid.imagesLoaded().progress(function() {
    grid.masonry('layout');
  });
}());
