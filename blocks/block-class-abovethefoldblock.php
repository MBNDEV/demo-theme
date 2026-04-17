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
   * Front assets under block-assets/block-assets-abovethefoldblock/.
   */
  protected const ASSET_SUBDIR = 'block-assets-abovethefoldblock';

  /**
   * Handle slug for custom-theme-bk-*-js/css.
   */
  protected const ASSET_HANDLE_SLUG = 'abovethefold';

  /**
   * Inline block.css when the block is present.
   */
  protected const ASSET_HAS_CSS = true;

  /**
   * Must match Carbon's registered block name.
   */
  protected const WP_BLOCK_NAME = 'carbon-fields/above-the-fold-content';

  /**
   * Register the block with Carbon Fields.
   *
   * @return void
   */
  public static function register(): void {
    Container::make( 'block', __( 'Above The Fold Content', CUSTOM_THEME_TEXT_DOMAIN ) )
      ->set_icon( 'cover-image' )
      ->set_category( CUSTOM_THEME_BLOCK_CATEGORY, custom_theme_get_theme_blocks_category_title() )
      ->set_render_callback( array( self::class, 'render' ) )
      ->add_fields(
        array_merge(
          Abstract_Block::get_block_name_heading_field( __( 'Above The Fold Block', CUSTOM_THEME_TEXT_DOMAIN ), 'above_fold' ),
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
		Field::make( 'text', 'crb_above_fold_eyebrow', __( 'Eyebrow', CUSTOM_THEME_TEXT_DOMAIN ) )
		  ->set_default_value( __( 'Custom WordPress Development', CUSTOM_THEME_TEXT_DOMAIN ) ),
		Field::make( 'text', 'crb_above_fold_title', __( 'Title', CUSTOM_THEME_TEXT_DOMAIN ) )
		  ->set_default_value( __( 'WordPress Custom Fields Library', CUSTOM_THEME_TEXT_DOMAIN ) ),
		Field::make( 'textarea', 'crb_above_fold_description', __( 'Description', CUSTOM_THEME_TEXT_DOMAIN ) )
		  ->set_default_value( __( 'Build repeatable, developer-friendly content sections for modern WordPress websites.', CUSTOM_THEME_TEXT_DOMAIN ) ),
		Field::make( 'text', 'crb_above_fold_button_text', __( 'Button Text', CUSTOM_THEME_TEXT_DOMAIN ) )
		  ->set_default_value( __( 'Get Started', CUSTOM_THEME_TEXT_DOMAIN ) ),
		Field::make( 'text', 'crb_above_fold_button_url', __( 'Button URL', CUSTOM_THEME_TEXT_DOMAIN ) )
		  ->set_default_value( home_url( '/' ) ),
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
		  'eyebrow'     => $fields['crb_above_fold_eyebrow'] ?? '',
		  'title'       => $fields['crb_above_fold_title'] ?? '',
		  'description' => $fields['crb_above_fold_description'] ?? '',
		  'button_text' => $fields['crb_above_fold_button_text'] ?? '',
		  'button_url'  => $fields['crb_above_fold_button_url'] ?? '',
	  ),
      Abstract_Block::map_advanced_fields_to_template_args( $fields )
    );
  }
}
