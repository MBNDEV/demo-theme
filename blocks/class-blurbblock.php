<?php
/**
 * Blurb — Carbon Fields Gutenberg block.
 *
 * @package CustomTheme
 */

namespace CustomTheme\Blocks;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

/**
 * Registers fields and renders the blurb output in blocks-render/.
 */
final class BlurbBlock extends Abstract_Block {

  /**
   * Register the block with Carbon Fields.
   *
   * @return void
   */
  public static function register(): void {
    Container::make( 'block', __( 'Blurb', 'custom-theme' ) )
      ->set_icon( 'format-image' )
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
      'blocks-render/render-blurbblock',
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
		Field::make( 'image', 'crb_blurb_image', __( 'Image', 'custom-theme' ) )
		  ->set_value_type( 'id' ),
		Field::make( 'textarea', 'crb_blurb_text', __( 'Text', 'custom-theme' ) )
		  ->set_default_value( __( 'Feature blurb text goes here.', 'custom-theme' ) ),
		Field::make( 'color', 'crb_blurb_background_color', __( 'Background Color', 'custom-theme' ) )
		  ->set_default_value( '#FFFFFF' ),
		Field::make( 'color', 'crb_blurb_text_color', __( 'Text Color', 'custom-theme' ) )
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
		  'image_id'         => isset( $fields['crb_blurb_image'] ) ? absint( $fields['crb_blurb_image'] ) : 0,
		  'text'             => $fields['crb_blurb_text'] ?? '',
		  'background_color' => $fields['crb_blurb_background_color'] ?? '',
		  'text_color'       => $fields['crb_blurb_text_color'] ?? '',
	  ),
      Abstract_Block::map_advanced_fields_to_template_args( $fields )
    );
  }
}
