<?php
/**
 * Theme-wide constants (text domain, block categories).
 *
 * @package CustomTheme
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

if ( ! defined( 'CUSTOM_THEME_TEXT_DOMAIN' ) ) {
  define( 'CUSTOM_THEME_TEXT_DOMAIN', 'custom-theme' );
}

/**
 * Block inserter category slug for all theme-registered blocks (see block_categories_all).
 */
if ( ! defined( 'CUSTOM_THEME_BLOCK_CATEGORY' ) ) {
  define( 'CUSTOM_THEME_BLOCK_CATEGORY', 'theme-blocks' );
}

/**
 * Default English label for CUSTOM_THEME_BLOCK_CATEGORY (inserter panel title: .block-editor-inserter__panel-title).
 */
if ( ! defined( 'CUSTOM_THEME_BLOCK_CATEGORY_TITLE' ) ) {
  define( 'CUSTOM_THEME_BLOCK_CATEGORY_TITLE', 'Theme Blocks' );
}

/**
 * Translated inserter category title for theme blocks.
 *
 * Keep in sync with CUSTOM_THEME_BLOCK_CATEGORY_TITLE.
 *
 * @return string
 */
function custom_theme_get_theme_blocks_category_title(): string {
  return __( 'Theme Blocks', CUSTOM_THEME_TEXT_DOMAIN );
}

/**
 * Registered image size name for section background fallbacks (tablet breakpoint).
 *
 * @see custom_theme_register_section_background_image_sizes()
 */
if ( ! defined( 'CUSTOM_THEME_SECTION_BG_TABLET_IMAGE_SIZE' ) ) {
  define( 'CUSTOM_THEME_SECTION_BG_TABLET_IMAGE_SIZE', 'custom-theme-section-tablet' );
}

/**
 * Registered image size name for section background fallbacks (mobile breakpoint).
 *
 * @see custom_theme_register_section_background_image_sizes()
 */
if ( ! defined( 'CUSTOM_THEME_SECTION_BG_MOBILE_IMAGE_SIZE' ) ) {
  define( 'CUSTOM_THEME_SECTION_BG_MOBILE_IMAGE_SIZE', 'custom-theme-section-mobile' );
}
