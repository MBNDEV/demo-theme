/**
 * Above the fold block — sample front script (runs only when this block is on the page).
 */
(function () {
  'use strict';

  document.querySelectorAll(
    '[data-custom-theme-block="above-the-fold-content"]'
  ).forEach(
    function (section) {
      section.setAttribute( 'data-custom-theme-js', '1' );
    }
  );
}());
