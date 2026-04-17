<?php
/**
 * Reusable Section — full-width section shell with inner blocks (background color + responsive images).
 *
 * @package CustomTheme
 */

namespace CustomTheme\Blocks;

use Carbon_Fields\Container;

/**
 * Registers a wrapper block that applies shared section styling and renders nested blocks inside.
 */
final class ReusableSectionBlock extends Abstract_Block {

  /**
   * Must match Carbon's registered block name.
   */
  protected const WP_BLOCK_NAME = 'carbon-fields/reusable-section';

  /**
   * Register the block with Carbon Fields.
   *
   * @return void
   */
  public static function register(): void {
    Container::make( 'block', __( 'Reusable Section', CUSTOM_THEME_TEXT_DOMAIN ) )
      ->set_icon( 'align-full' )
      ->set_category( CUSTOM_THEME_BLOCK_CATEGORY, custom_theme_get_theme_blocks_category_title() )
      ->set_inner_blocks( true )
      ->set_inner_blocks_position( 'below' )
      ->set_render_callback( array( self::class, 'render' ) )
      ->add_fields(
        array_merge(
          Abstract_Block::get_block_name_heading_field( __( 'Reusable Section', CUSTOM_THEME_TEXT_DOMAIN ), 'reusable_section' ),
          Abstract_Block::get_advanced_field_definitions()
        )
      );
  }

  /**
   * Render callback for the block.
   *
   * @param array<string, mixed> $fields    Carbon field values.
   * @param mixed                $attributes Block attributes (unused).
   * @param string               $content   Inner blocks HTML.
   * @param mixed                $post_id   Current post ID (unused).
   * @param mixed                $block     WP_Block instance (unused).
   * @return void
   */
  public static function render( $fields, $attributes = null, $content = '', $post_id = null, $block = null ): void {
    unset( $attributes, $post_id, $block );

    $fields  = is_array( $fields ) ? $fields : array();
    $content = is_string( $content ) ? $content : '';

    get_template_part(
      'blocks-render/render-reusablesection',
      null,
      array_merge(
        Abstract_Block::map_advanced_fields_to_template_args( $fields ),
        array(
			'inner_html'              => $content,
			'data_custom_theme_block' => 'reusable-section',
			'inner_container_classes' => 'mx-auto container',
        )
      )
    );
  }
}
