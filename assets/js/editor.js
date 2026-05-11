(function ($) {
  function initSlickSlider($scope) {
    var $slider = $scope.find(".news-carousel");
    if ($slider.length && !$slider.hasClass("slick-initialized")) {
      $slider.slick({
        slidesToShow: 3,
        dots: true,
        arrows: true,
        autoplay: true,
        autoplaySpeed: 3000,
      });
    }
  }

  $(window).on("elementor/frontend/init", function () {
    // For front-end and live preview
    elementorFrontend.hooks.addAction(
      "frontend/element_ready/global",
      initSlickSlider
    );
  });
})(jQuery);
