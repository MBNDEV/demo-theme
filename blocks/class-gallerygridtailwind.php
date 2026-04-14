<?php
/**
 * Gallery Grid Tailwind — Carbon Fields Gutenberg block.
 *
 * @package CustomTheme
 */

namespace CustomTheme\Blocks;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

/**
 * Registers fields and renders the gallery grid output in blocks-render/.
 */
final class GalleryGridTailwind extends Abstract_Block {

  /**
   * Register the block with Carbon Fields.
   *
   * @return void
   */
  public static function register(): void {
    Container::make( 'block', __( 'Gallery Grid Tailwind', 'custom-theme' ) )
      ->set_icon( 'images-alt2' )
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
      'blocks-render/render-gallerygridtailwind',
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
		Field::make( 'text', 'crb_gallery_grid_title', __( 'Title', 'custom-theme' ) )
		  ->set_default_value( __( 'Gallery Grid', 'custom-theme' ) ),
		Field::make( 'media_gallery', 'crb_gallery_grid_images', __( 'Images', 'custom-theme' ) )
		  ->set_type( array( 'image' ) ),
		Field::make( 'color', 'crb_gallery_grid_background_color', __( 'Background Color', 'custom-theme' ) )
		  ->set_default_value( '#FFFFFF' ),
		Field::make( 'color', 'crb_gallery_grid_text_color', __( 'Text Color', 'custom-theme' ) )
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
    $raw_image_ids = $fields['crb_gallery_grid_images'] ?? array();
    $image_ids     = array();

    if ( is_array( $raw_image_ids ) ) {
      $image_ids = array_map( 'absint', $raw_image_ids );
      $image_ids = array_values(
        array_filter(
          $image_ids,
          static function ( int $image_id ): bool {
            return $image_id > 0;
          }
        )
      );
    }

    return array_merge(
      array(
		  'title'            => $fields['crb_gallery_grid_title'] ?? '',
		  'image_ids'        => $image_ids,
		  'background_color' => $fields['crb_gallery_grid_background_color'] ?? '',
		  'text_color'       => $fields['crb_gallery_grid_text_color'] ?? '',
      ),
      Abstract_Block::map_advanced_fields_to_template_args( $fields )
    );
  }
}
