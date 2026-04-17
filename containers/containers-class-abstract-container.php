<?php
/**
 * Base for Carbon Fields admin containers (theme options, post meta, etc.).
 *
 * @package CustomTheme
 */

namespace CustomTheme\Containers;

use Carbon_Fields\Field;

/**
 * Contract for theme containers registered with Carbon Fields.
 */
abstract class Abstract_Container {

  /** Shared textarea height for Custom HTML fields (Preset Options + posts/pages). */
  public const CUSTOM_HTML_TEXTAREA_ROWS = 10;

  /**
   * Register the Carbon Fields container and its fields.
   *
   * @return void
   */
  abstract public static function register(): void;

  /**
   * Separator + Head / Before Body / After Body / Footer textareas (like Abstract_Block::get_advanced_field_definitions()).
   *
   * @param string $field_name_prefix crb_global_html_ or crb_post_html_.
   * @param string $separator_field_id Unique separator field id.
   * @param string $separator_label    Separator title.
   * @param string $separator_help     Separator help text.
   * @param int    $textarea_rows Defaults to CUSTOM_HTML_TEXTAREA_ROWS (same for global and per-entry UIs).
   * @return array<int, mixed>
   */
  public static function get_custom_html_field_definitions(
      string $field_name_prefix,
      string $separator_field_id,
      string $separator_label,
      string $separator_help,
      int $textarea_rows = self::CUSTOM_HTML_TEXTAREA_ROWS
  ): array {
    $slots = array(
		'head'        => array(
			'label' => __( 'Head', CUSTOM_THEME_TEXT_DOMAIN ),
			'help'  => __( 'Printed inside the document head (e.g. meta tags, styles).', CUSTOM_THEME_TEXT_DOMAIN ),
		),
		'before_body' => array(
			'label' => __( 'Before Body', CUSTOM_THEME_TEXT_DOMAIN ),
			'help'  => __( 'Printed right after the opening body tag.', CUSTOM_THEME_TEXT_DOMAIN ),
		),
		'after_body'  => array(
			'label' => __( 'After Body', CUSTOM_THEME_TEXT_DOMAIN ),
			'help'  => __( 'Printed after the main page wrapper, before footer scripts.', CUSTOM_THEME_TEXT_DOMAIN ),
		),
		'footer'      => array(
			'label' => __( 'Footer', CUSTOM_THEME_TEXT_DOMAIN ),
			'help'  => __( 'Printed at the start of wp_footer (before most scripts).', CUSTOM_THEME_TEXT_DOMAIN ),
		),
    );

    $fields = array(
		Field::make( 'separator', $separator_field_id, $separator_label )->set_help_text( $separator_help ),
    );

    foreach ( $slots as $suffix => $meta ) {
      $fields[] = Field::make( 'textarea', $field_name_prefix . $suffix, $meta['label'] )
        ->set_rows( $textarea_rows )
        ->set_help_text( $meta['help'] );
    }

    return $fields;
  }
}
