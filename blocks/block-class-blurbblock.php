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
   * Front assets under block-assets/block-assets-blurbblock/.
   */
  protected const ASSET_SUBDIR = 'block-assets-blurbblock';

  /**
   * Handle slug for custom-theme-bk-*-js/css.
   */
  protected const ASSET_HANDLE_SLUG = 'blurb';

  /**
   * Inline block.css when the block is present.
   */
  protected const ASSET_HAS_CSS = true;

  /**
   * Must match Carbon's registered block name.
   */
  protected const WP_BLOCK_NAME = 'carbon-fields/blurb';

  /**
   * Register the block with Carbon Fields.
   *
   * @return void
   */
  public static function register(): void {
    Container::make( 'block', __( 'Blurb', CUSTOM_THEME_TEXT_DOMAIN ) )
      ->set_icon( 'format-image' )
      ->set_category( CUSTOM_THEME_BLOCK_CATEGORY, custom_theme_get_theme_blocks_category_title() )
      ->set_render_callback( array( self::class, 'render' ) )
      ->add_fields(
        array_merge(
          Abstract_Block::get_block_name_heading_field( __( 'Blurb Block', CUSTOM_THEME_TEXT_DOMAIN ), 'blurb' ),
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
		Field::make( 'image', 'crb_blurb_image', __( 'Image', CUSTOM_THEME_TEXT_DOMAIN ) )
		  ->set_value_type( 'id' ),
		Field::make( 'textarea', 'crb_blurb_text', __( 'Text', CUSTOM_THEME_TEXT_DOMAIN ) )
		  ->set_default_value( __( 'Feature blurb text goes here.', CUSTOM_THEME_TEXT_DOMAIN ) ),
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
		  'image_id' => isset( $fields['crb_blurb_image'] ) ? absint( $fields['crb_blurb_image'] ) : 0,
		  'text'     => $fields['crb_blurb_text'] ?? '',
	  ),
      Abstract_Block::map_advanced_fields_to_template_args( $fields )
    );
  }
}
