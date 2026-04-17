/**
 * Blurb block — sample front script (runs only when this block is on the page).
 */
(function () {
  'use strict';

  document.querySelectorAll(
    '[data-custom-theme-block="blurb"]'
  ).forEach(
    function (section) {
      section.setAttribute( 'data-custom-theme-js', '1' );
    }
  );
}());
