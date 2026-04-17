<?php
/**
 * Front-end performance: optional removal of core emoji, block assets, and classic theme styles.
 *
 * @package CustomTheme
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

/**
 * Whether theme options request removing block-related front assets (block library, global styles, stored styles).
 *
 * @return bool
 */
function custom_theme_optimize_should_remove_front_block_global(): bool {
  $raw = carbon_get_theme_option( 'crb_opt_front_remove_block_global' );
  if ( null === $raw || '' === $raw ) {
    return true;
  }

  return ( 'yes' === $raw );
}

/**
 * Whether theme options request removing classic theme styles on the front end.
 *
 * @return bool
 */
function custom_theme_optimize_should_remove_front_classic_theme_styles(): bool {
  $raw = carbon_get_theme_option( 'crb_opt_front_remove_classic_theme_styles' );
  if ( null === $raw || '' === $raw ) {
    return true;
  }

  return ( 'yes' === $raw );
}

/**
 * Remove Twemoji / emoji scripts and styles (front and admin).
 *
 * @return void
 */
function custom_theme_disable_wp_emoji(): void {
  remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
  remove_action( 'wp_print_styles', 'print_emoji_styles' );
  remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
  remove_action( 'admin_print_styles', 'print_emoji_styles' );
  remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
  remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
  remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
  add_filter( 'emoji_svg_url', '__return_false' );
}
add_action( 'init', 'custom_theme_disable_wp_emoji', 1 );

/**
 * Conditionally remove core block / global / stored styles and classic theme styles on the front end only.
 *
 * @return void
 */
function custom_theme_optimize_remove_front_core_block_and_theme_styles(): void {
  if ( is_admin() ) {
    return;
  }

  if ( custom_theme_optimize_should_remove_front_block_global() ) {
    remove_action( 'wp_enqueue_scripts', 'wp_common_block_scripts_and_styles' );
    remove_action( 'wp_enqueue_scripts', 'wp_enqueue_global_styles' );
    remove_action( 'wp_footer', 'wp_enqueue_global_styles', 1 );
    remove_action( 'wp_enqueue_scripts', 'wp_enqueue_stored_styles' );
    remove_action( 'wp_footer', 'wp_enqueue_stored_styles', 1 );
  }

  if ( custom_theme_optimize_should_remove_front_classic_theme_styles() ) {
    remove_action( 'wp_enqueue_scripts', 'wp_enqueue_classic_theme_styles' );
  }
}
add_action( 'init', 'custom_theme_optimize_remove_front_core_block_and_theme_styles', 1 );
