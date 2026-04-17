<?php
/**
 * Base for Carbon Fields Gutenberg block modules.
 *
 * @package CustomTheme
 */

namespace CustomTheme\Blocks;

use Carbon_Fields\Field;

/**
 * Contract for theme blocks registered with Carbon Fields.
 */
abstract class Abstract_Block {

  /**
   * Advanced section background (outer wrapper).
   */
  public const SECTION_BG_COLOR_FIELD = 'crb_block_section_bg_color';

  /**
   * Section text color (inherited by inner content unless overridden).
   */
  public const SECTION_TEXT_COLOR_FIELD = 'crb_block_section_text_color';

  /**
   * Responsive background images (tablet/mobile fall back per Abstract_Block mapping).
   */
  public const SECTION_BG_IMAGE_DESKTOP_FIELD = 'crb_block_section_bg_image_desktop';

  public const SECTION_BG_IMAGE_TABLET_FIELD = 'crb_block_section_bg_image_tablet';

  public const SECTION_BG_IMAGE_MOBILE_FIELD = 'crb_block_section_bg_image_mobile';

  /**
   * Carbon HTML field base name (unique per block via suffix).
   */
  public const BLOCK_HEADING_FIELD = 'crb_block_editor_heading';

  /**
   * Register the Carbon Fields block container.
   *
   * @return void
   */
  abstract public static function register(): void;

  /**
   * Non-editable HTML heading showing the block name in the editor (not rendered on the front).
   *
   * @param string $heading_text Translated block name, e.g. "Testimonial Block".
   * @param string $field_suffix Unique suffix for the field name (letters/numbers/underscore).
   * @return array<int, mixed>
   */
  public static function get_block_name_heading_field( string $heading_text, string $field_suffix ): array {
    $field_name = self::BLOCK_HEADING_FIELD . '_' . $field_suffix;

    return array(
		Field::make( 'html', $field_name, '' )
		  ->set_html(
            '<h1 class="crb-block-editor-heading" style="margin:0 0 12px;padding:0;font-size:20px;font-weight:900;line-height:1.4;">'
			  . CUSTOM_THEME_BLOCK_CATEGORY_TITLE . ': ' . esc_html( $heading_text )
			  . '</h1>'
		  ),
    );
  }

  /**
   * Advanced options: section background and text colors, responsive background images.
   *
   * @return array<int, mixed>
   */
  public static function get_advanced_field_definitions(): array {
    return array(
		Field::make( 'separator', 'crb_block_advanced_sep', __( 'Advanced options', CUSTOM_THEME_TEXT_DOMAIN ) ),
		Field::make( 'color', self::SECTION_BG_COLOR_FIELD, __( 'Section background color', CUSTOM_THEME_TEXT_DOMAIN ) )
		  ->set_width( 50 ),
		Field::make( 'color', self::SECTION_TEXT_COLOR_FIELD, __( 'Section text color', CUSTOM_THEME_TEXT_DOMAIN ) )
		  ->set_width( 50 ),
		Field::make( 'separator', 'crb_block_section_bg_images_sep', __( 'Section background images', CUSTOM_THEME_TEXT_DOMAIN ) )
		  ->set_width( 100 ),
		Field::make( 'image', self::SECTION_BG_IMAGE_DESKTOP_FIELD, __( 'Desktop', CUSTOM_THEME_TEXT_DOMAIN ) )
		  ->set_value_type( 'id' )
		  ->set_width( 33 )
		  ->set_help_text( __( 'Shown from 1024px and up. Used as fallback when tablet or mobile image is not set.', CUSTOM_THEME_TEXT_DOMAIN ) ),
		Field::make( 'image', self::SECTION_BG_IMAGE_TABLET_FIELD, __( 'Tablet', CUSTOM_THEME_TEXT_DOMAIN ) )
		  ->set_value_type( 'id' )
		  ->set_width( 33 )
		  ->set_help_text( __( 'Shown from 640px–1023px. Falls back to desktop if empty.', CUSTOM_THEME_TEXT_DOMAIN ) ),
		Field::make( 'image', self::SECTION_BG_IMAGE_MOBILE_FIELD, __( 'Mobile', CUSTOM_THEME_TEXT_DOMAIN ) )
		  ->set_value_type( 'id' )
		  ->set_width( 34 )
		  ->set_help_text( __( 'Shown below 640px. Falls back to tablet, then desktop, if empty.', CUSTOM_THEME_TEXT_DOMAIN ) ),
    );
  }

  /**
   * Map shared advanced fields into template arguments.
   *
   * @param array<string, mixed> $fields Raw Carbon field values.
   * @return array{
   *   section_bg_color: string,
   *   section_text_color: string,
   *   section_bg_image_desktop: int,
   *   section_bg_image_tablet: int,
   *   section_bg_image_mobile: int
   * }
   */
  public static function map_advanced_fields_to_template_args( array $fields ): array {
    $bg_raw = isset( $fields[ self::SECTION_BG_COLOR_FIELD ] ) ? sanitize_hex_color( (string) $fields[ self::SECTION_BG_COLOR_FIELD ] ) : '';
    $bg     = ( is_string( $bg_raw ) && '' !== $bg_raw ) ? $bg_raw : '';

    $fg_raw = isset( $fields[ self::SECTION_TEXT_COLOR_FIELD ] ) ? sanitize_hex_color( (string) $fields[ self::SECTION_TEXT_COLOR_FIELD ] ) : '';
    $fg     = ( is_string( $fg_raw ) && '' !== $fg_raw ) ? $fg_raw : '';

    return array(
		'section_bg_color'         => $bg,
		'section_text_color'       => $fg,
		'section_bg_image_desktop' => isset( $fields[ self::SECTION_BG_IMAGE_DESKTOP_FIELD ] ) ? absint( $fields[ self::SECTION_BG_IMAGE_DESKTOP_FIELD ] ) : 0,
		'section_bg_image_tablet'  => isset( $fields[ self::SECTION_BG_IMAGE_TABLET_FIELD ] ) ? absint( $fields[ self::SECTION_BG_IMAGE_TABLET_FIELD ] ) : 0,
		'section_bg_image_mobile'  => isset( $fields[ self::SECTION_BG_IMAGE_MOBILE_FIELD ] ) ? absint( $fields[ self::SECTION_BG_IMAGE_MOBILE_FIELD ] ) : 0,
    );
  }

  /**
   * Subdirectory under `block-assets/` (`block-assets-{blockname}/`) with `script.js` and optional `block.css`.
   */
  protected const ASSET_SUBDIR = '';

  /**
   * Short slug for handles: `custom-theme-bk-{slug}-js` / `-css`.
   */
  protected const ASSET_HANDLE_SLUG = '';

  /**
   * Whether `block.css` is registered and inlined.
   */
  protected const ASSET_HAS_CSS = false;

  /**
   * Carbon block name for `has_block()`, e.g. `carbon-fields/blurb`.
   */
  protected const WP_BLOCK_NAME = '';

  /**
   * Carbon-registered block name for `has_block()`, e.g. carbon-fields/blurb.
   *
   * @return string Empty when this block has no front assets.
   */
  public static function get_wp_block_name(): string {
    return static::WP_BLOCK_NAME;
  }

  /**
   * Register optional front script and inline-only style handle (no-op by default).
   *
   * @return void
   */
  public static function register_assets(): void {
    if ( '' === static::ASSET_SUBDIR || '' === static::ASSET_HANDLE_SLUG ) {
      return;
    }
    static::register_block_asset_bundle();
  }

  /**
   * Script handle from register_assets(), or empty when none.
   *
   * @return string
   */
  public static function get_script_handle(): string {
    if ( '' === static::ASSET_HANDLE_SLUG ) {
      return '';
    }

    return 'custom-theme-bk-' . static::ASSET_HANDLE_SLUG . '-js';
  }

  /**
   * Style handle for wp_add_inline_style(), or empty when none.
   *
   * @return string
   */
  public static function get_style_handle(): string {
    if ( ! static::ASSET_HAS_CSS || '' === static::ASSET_HANDLE_SLUG ) {
      return '';
    }

    return 'custom-theme-bk-' . static::ASSET_HANDLE_SLUG . '-css';
  }

  /**
   * CSS to print inline for this block (after enqueue), or empty.
   *
   * @return string
   */
  public static function get_inline_style_css(): string {
    if ( ! static::ASSET_HAS_CSS || '' === static::ASSET_SUBDIR ) {
      return '';
    }

    $path = get_theme_file_path( 'block-assets/' . static::ASSET_SUBDIR . '/block.css' );

    return custom_theme_read_block_asset_file( $path );
  }

  /**
   * Registers script.js and optional inline-only style handle.
   *
   * @return void
   */
  protected static function register_block_asset_bundle(): void {
    $subdir  = static::ASSET_SUBDIR;
    $js_path = get_theme_file_path( 'block-assets/' . $subdir . '/script.js' );
    if ( ! is_readable( $js_path ) ) {
      return;
    }

    $js_uri = get_theme_file_uri( 'block-assets/' . $subdir . '/script.js' );
    wp_register_script(
      static::get_script_handle(),
      $js_uri,
      array(),
      (string) filemtime( $js_path ),
      true
    );

    if ( ! static::ASSET_HAS_CSS ) {
      return;
    }

    $css_path = get_theme_file_path( 'block-assets/' . $subdir . '/block.css' );
    if ( ! is_readable( $css_path ) ) {
      return;
    }

    wp_register_style(
      static::get_style_handle(),
      false,
      array(),
      (string) filemtime( $css_path )
    );
  }
}
