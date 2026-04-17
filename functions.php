<?php
/**
 * Custom Theme functions and setup.
 *
 * @package CustomTheme
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

require_once get_theme_file_path( 'theme-constants.php' );
require_once get_theme_file_path( 'inc/includes-theme-block-section.php' );

// Always load theme Composer autoload: Carbon Fields and blocks/containers classmap
// depend on it. Do not gate on Plugin Update Checker — another plugin may load PUC
// first, which would skip autoload and break Carbon_Fields.
require_once get_theme_file_path( 'vendor/autoload.php' );

require_once get_theme_file_path( 'inc/includes-template-carbon-cpt.php' );
require_once get_theme_file_path( 'inc/includes-template-page-sync.php' );

use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

PucFactory::buildUpdateChecker(
  'https://github.com/MBNDEV/custom-theme',
  get_theme_file_path( 'style.css' ),
  CUSTOM_THEME_TEXT_DOMAIN
);

require_once get_theme_file_path( 'carbon-loader.php' );
require_once get_theme_file_path( 'tailwind-loader.php' );
// Includes.
require_once get_theme_file_path( 'inc/includes-block-assets.php' );
require_once get_theme_file_path( 'inc/includes-theme-preset-options-render.php' );
require_once get_theme_file_path( 'inc/includes-optimize.php' );
require_once get_theme_file_path( 'inc/includes-html-injection.php' );
require_once get_theme_file_path( 'inc/includes-widget-loader.php' );
