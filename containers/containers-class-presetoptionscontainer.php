<?php
/**
 * Preset Options — Carbon Fields theme options (Appearance).
 *
 * @package CustomTheme
 */

namespace CustomTheme\Containers;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

/**
 * Registers the Preset Options theme options page under Appearance.
 */
final class PresetOptionsContainer extends Abstract_Container {

  /**
   * Register the container with Carbon Fields.
   *
   * @return void
   */
  public static function register(): void {
    $font_choices = array();
    foreach ( custom_theme_get_font_presets() as $slug => $preset ) {
      $font_choices[ $slug ] = $preset['label'];
    }

    Container::make( 'theme_options', __( 'Preset Options', CUSTOM_THEME_TEXT_DOMAIN ) )
      ->set_page_parent( 'themes.php' )
      ->add_fields(
        array(
			Field::make( 'separator', 'crb_font_typography_sep', __( 'Typography', CUSTOM_THEME_TEXT_DOMAIN ) ),
			Field::make( 'select', 'crb_font_primary', __( 'Primary font (headings)', CUSTOM_THEME_TEXT_DOMAIN ) )
			  ->set_options( $font_choices )
			  ->set_default_value( 'inter' )
			  ->set_help_text( __( 'Applied to heading tags (h1–h6).', CUSTOM_THEME_TEXT_DOMAIN ) ),
			Field::make( 'select', 'crb_font_secondary', __( 'Secondary font (body)', CUSTOM_THEME_TEXT_DOMAIN ) )
			  ->set_options( $font_choices )
			  ->set_default_value( 'system_sans' )
			  ->set_help_text( __( 'Applied to body text.', CUSTOM_THEME_TEXT_DOMAIN ) ),
			Field::make( 'separator', 'crb_sample_fields_sep', __( 'Appearance', CUSTOM_THEME_TEXT_DOMAIN ) ),
			Field::make( 'color', 'crb_primary_accent_color', __( 'Primary accent', CUSTOM_THEME_TEXT_DOMAIN ) )
			  ->set_default_value( '#2563EB' )
			  ->set_help_text( __( 'Maps to CSS variable --cbb-accent-primary on :root.', CUSTOM_THEME_TEXT_DOMAIN ) ),
			Field::make( 'color', 'crb_secondary_accent_color', __( 'Secondary accent', CUSTOM_THEME_TEXT_DOMAIN ) )
			  ->set_default_value( '#64748B' )
			  ->set_help_text( __( 'Maps to CSS variable --cbb-accent-secondary on :root.', CUSTOM_THEME_TEXT_DOMAIN ) ),
			Field::make( 'separator', 'crb_performance_sep', __( 'Performance', CUSTOM_THEME_TEXT_DOMAIN ) ),
			Field::make( 'checkbox', 'crb_opt_front_remove_block_global', __( 'Remove core block scripts, global styles, and stored styles on the front end', CUSTOM_THEME_TEXT_DOMAIN ) )
			  ->set_default_value( true )
			  ->set_help_text( __( 'When enabled, skips loading the block library, theme.json global styles, and stored block styles on public pages. Disable if the front end needs those assets.', CUSTOM_THEME_TEXT_DOMAIN ) ),
			Field::make( 'checkbox', 'crb_opt_front_remove_classic_theme_styles', __( 'Remove classic theme styles on the front end', CUSTOM_THEME_TEXT_DOMAIN ) )
			  ->set_default_value( true )
			  ->set_help_text( __( 'When enabled, skips WordPress classic theme stylesheet output on public pages. Disable if you rely on that CSS.', CUSTOM_THEME_TEXT_DOMAIN ) ),
			...self::get_custom_html_field_definitions(
			  'crb_global_html_',
			  'crb_global_html_sep',
			  __( 'Custom HTML (global)', CUSTOM_THEME_TEXT_DOMAIN ),
			  __( 'Site-wide snippets. Individual posts and pages can override each field in the editor.', CUSTOM_THEME_TEXT_DOMAIN )
			),
        )
      );
  }
}
