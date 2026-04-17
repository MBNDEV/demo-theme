/**
 * Testimonials block — front script (loads only when this block is on the page).
 */
(function () {
  'use strict';

  document.querySelectorAll(
    '[data-custom-theme-block="testimonials"]'
  ).forEach(
    function (section) {
      section.setAttribute( 'data-custom-theme-js', '1' );
    }
  );
}());
  