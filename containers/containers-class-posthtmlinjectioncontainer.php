<?php
/**
 * Posts and pages — optional raw HTML snippets (override Preset Options when set).
 *
 * @package CustomTheme
 */

namespace CustomTheme\Containers;

use Carbon_Fields\Container;

/**
 * Registers Custom HTML fields on blog posts and pages.
 */
final class PostHtmlInjectionContainer extends Abstract_Container {

  /**
   * Register the container with Carbon Fields.
   *
   * @return void
   */
  public static function register(): void {
    Container::make( 'post_meta', __( 'Custom HTML', CUSTOM_THEME_TEXT_DOMAIN ) )
      ->show_on_post_type( array( 'post', 'page' ) )
      ->add_fields(
        self::get_custom_html_field_definitions(
          'crb_post_html_',
          'crb_post_html_sep',
          __( 'Custom HTML (this entry)', CUSTOM_THEME_TEXT_DOMAIN ),
          __( 'Overrides Preset Options for this page or post when a field is not empty.', CUSTOM_THEME_TEXT_DOMAIN )
        )
      );
  }
}
