<?php
/**
 * Custom Theme functions and setup.
 *
 * @package CustomTheme
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

if ( ! class_exists( 'YahnisElsts\PluginUpdateChecker\v5\PucFactory' ) ) {
  require_once get_theme_file_path( 'vendor/autoload.php' );
}

use Carbon_Fields\Container;
use Carbon_Fields\Field;
use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

PucFactory::buildUpdateChecker(
  'https://github.com/MBNDEV/custom-theme',
  get_theme_file_path( 'style.css' ),
  'custom-theme'
);

/**
 * Boot Carbon Fields.
 *
 * @return void
 */
function custom_theme_boot_carbon_fields() {
  \Carbon_Fields\Carbon_Fields::boot();
}
add_action( 'after_setup_theme', 'custom_theme_boot_carbon_fields' );

/**
 * Render callback for the Above The Fold Gutenberg block.
 *
 * @param array $fields Carbon Fields values.
 *
 * @return void
 */
function custom_theme_render_above_the_fold_block( $fields ) {
  get_template_part(
    'blocks/above-the-fold-content',
    null,
    array(
		'eyebrow'          => $fields['crb_above_fold_eyebrow'] ?? '',
		'title'            => $fields['crb_above_fold_title'] ?? '',
		'description'      => $fields['crb_above_fold_description'] ?? '',
		'button_text'      => $fields['crb_above_fold_button_text'] ?? '',
		'button_url'       => $fields['crb_above_fold_button_url'] ?? '',
		'background_color' => $fields['crb_above_fold_background_color'] ?? '',
		'text_color'       => $fields['crb_above_fold_text_color'] ?? '',
    )
  );
}

/**
 * Render callback for the Blurb Gutenberg block.
 *
 * @param array $fields Carbon Fields values.
 *
 * @return void
 */
function custom_theme_render_blurb_block( $fields ) {
  get_template_part(
    'blocks/blurb',
    null,
    array(
		'image_id'         => $fields['crb_blurb_image'] ?? 0,
		'text'             => $fields['crb_blurb_text'] ?? '',
		'background_color' => $fields['crb_blurb_background_color'] ?? '',
		'text_color'       => $fields['crb_blurb_text_color'] ?? '',
    )
  );
}

/**
 * Register Carbon Fields Gutenberg blocks.
 *
 * @return void
 */
function custom_theme_register_module_fields() {
  Container::make( 'block', __( 'Above The Fold Content', 'custom-theme' ) )
    ->set_icon( 'cover-image' )
    ->set_category( 'layout' )
    ->set_render_callback( 'custom_theme_render_above_the_fold_block' )
    ->add_fields(
      array(
		  Field::make( 'text', 'crb_above_fold_eyebrow', __( 'Eyebrow', 'custom-theme' ) )
			->set_default_value( __( 'Custom WordPress Development', 'custom-theme' ) ),
		  Field::make( 'text', 'crb_above_fold_title', __( 'Title', 'custom-theme' ) )
			->set_default_value( __( 'WordPress Custom Fields Library', 'custom-theme' ) ),
		  Field::make( 'textarea', 'crb_above_fold_description', __( 'Description', 'custom-theme' ) )
			->set_default_value( __( 'Build repeatable, developer-friendly content sections for modern WordPress websites.', 'custom-theme' ) ),
		  Field::make( 'text', 'crb_above_fold_button_text', __( 'Button Text', 'custom-theme' ) )
			->set_default_value( __( 'Get Started', 'custom-theme' ) ),
		  Field::make( 'text', 'crb_above_fold_button_url', __( 'Button URL', 'custom-theme' ) )
			->set_default_value( home_url( '/' ) ),
		  Field::make( 'color', 'crb_above_fold_background_color', __( 'Background Color', 'custom-theme' ) )
			->set_default_value( '#F5F7FF' ),
		  Field::make( 'color', 'crb_above_fold_text_color', __( 'Text Color', 'custom-theme' ) )
			->set_default_value( '#111827' ),
      )
    );

  Container::make( 'block', __( 'Blurb', 'custom-theme' ) )
    ->set_icon( 'format-image' )
    ->set_category( 'layout' )
    ->set_render_callback( 'custom_theme_render_blurb_block' )
    ->add_fields(
      array(
		  Field::make( 'image', 'crb_blurb_image', __( 'Image', 'custom-theme' ) )
			->set_value_type( 'id' ),
		  Field::make( 'textarea', 'crb_blurb_text', __( 'Text', 'custom-theme' ) )
			->set_default_value( __( 'Feature blurb text goes here.', 'custom-theme' ) ),
		  Field::make( 'color', 'crb_blurb_background_color', __( 'Background Color', 'custom-theme' ) )
			->set_default_value( '#FFFFFF' ),
		  Field::make( 'color', 'crb_blurb_text_color', __( 'Text Color', 'custom-theme' ) )
			->set_default_value( '#111827' ),
      )
    );
}
add_action( 'carbon_fields_register_fields', 'custom_theme_register_module_fields' );
