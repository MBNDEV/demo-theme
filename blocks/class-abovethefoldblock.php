<?php
/**
 * Above the fold — Carbon Fields Gutenberg block.
 *
 * @package CustomTheme
 */

namespace CustomTheme\Blocks;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

/**
 * Registers fields and renders the above-the-fold output in blocks-render/.
 */
final class AboveTheFoldBlock extends Abstract_Block {

  /**
   * Register the block with Carbon Fields.
   *
   * @return void
   */
  public static function register(): void {
    Container::make( 'block', __( 'Above The Fold Content', 'custom-theme' ) )
      ->set_icon( 'cover-image' )
      ->set_category( 'layout' )
      ->set_render_callback( array( self::class, 'render' ) )
      ->add_fields(
        array_merge(
          self::get_field_definitions(),
          Abstract_Block::get_advanced_field_definitions()
        )
      );
  }

  /**
   * Render callback for the block.
   *
   * @param array<string, mixed> $fields Carbon field values.
   * @return void
   */
  public static function render( $fields ): void {
    get_template_part(
      'blocks-render/render-abovethefoldblock',
      null,
      self::map_fields_to_template_args( is_array( $fields ) ? $fields : array() )
    );
  }

  /**
   * Field definitions for this block.
   *
   * @return array<int, mixed>
   */
  private static function get_field_definitions(): array {
    return array(
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
    );
  }

  /**
   * Map stored field keys to template part arguments.
   *
   * @param array<string, mixed> $fields Raw field values.
   * @return array<string, mixed>
   */
  private static function map_fields_to_template_args( array $fields ): array {
    return array_merge(
      array(
		  'eyebrow'          => $fields['crb_above_fold_eyebrow'] ?? '',
		  'title'            => $fields['crb_above_fold_title'] ?? '',
		  'description'      => $fields['crb_above_fold_description'] ?? '',
		  'button_text'      => $fields['crb_above_fold_button_text'] ?? '',
		  'button_url'       => $fields['crb_above_fold_button_url'] ?? '',
		  'background_color' => $fields['crb_above_fold_background_color'] ?? '',
		  'text_color'       => $fields['crb_above_fold_text_color'] ?? '',
	  ),
      Abstract_Block::map_advanced_fields_to_template_args( $fields )
    );
  }
}
