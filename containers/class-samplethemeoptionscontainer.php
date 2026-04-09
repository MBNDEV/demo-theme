<?php
/**
 * Sample theme options — Carbon Fields container (demo).
 *
 * @package CustomTheme
 */

namespace CustomTheme\Containers;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

/**
 * Registers a sample Theme Options page under Appearance.
 */
final class SampleThemeOptionsContainer extends Abstract_Container {

  /**
   * Register the container with Carbon Fields.
   *
   * @return void
   */
  public static function register(): void {
    Container::make( 'theme_options', __( 'Sample Options', 'custom-theme' ) )
      ->set_page_parent( 'themes.php' )
      ->add_fields(
        array(
			Field::make( 'text', 'crb_sample_site_tagline_extra', __( 'Extra Tagline', 'custom-theme' ) )
			  ->set_help_text( __( 'Optional line shown with the site tagline (sample field).', 'custom-theme' ) ),
			Field::make( 'color', 'crb_sample_accent_color', __( 'Accent Color', 'custom-theme' ) )
			  ->set_default_value( '#2563EB' ),
        )
      );
  }
}
