<?php
/**
 * Template — embed main body from a Carbon Template (block editor only; not Header/Footer meta).
 *
 * @package CustomTheme
 */

namespace CustomTheme\Blocks;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

/**
 * Renders another Carbon Template post’s block editor content only.
 */
final class TemplateBlock extends Abstract_Block {

  /**
   * Register the block with Carbon Fields.
   *
   * @return void
   */
  public static function register(): void {
    add_filter(
      'carbon_fields_association_field_options_crb_template_block_source_post_carbon_template',
      array( self::class, 'filter_template_block_association_post_query' )
    );

    Container::make( 'block', __( 'Template', CUSTOM_THEME_TEXT_DOMAIN ) )
      ->set_icon( 'layout' )
      ->set_category( CUSTOM_THEME_BLOCK_CATEGORY, custom_theme_get_theme_blocks_category_title() )
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
      'blocks-render/render-templateblock',
      null,
      self::map_fields_to_template_args( is_array( $fields ) ? $fields : array() )
    );
  }

  /**
   * Exclude global chrome and page-layout Carbon Templates from the association query.
   *
   * @param array<string, mixed> $args WP_Query arguments for Carbon Fields association SQL.
   * @return array<string, mixed>
   */
  public static function filter_template_block_association_post_query( array $args ): array {
    $exclude = custom_theme_get_carbon_template_post_ids_excluded_from_template_block();
    if ( empty( $exclude ) ) {
      return $args;
    }

    $existing             = isset( $args['post__not_in'] ) ? (array) $args['post__not_in'] : array();
    $args['post__not_in'] = array_values( array_unique( array_merge( $existing, $exclude ) ) );

    return $args;
  }

  /**
   * Resolve associated Carbon Template post ID from field value.
   *
   * @param array<string, mixed> $fields Raw field values.
   * @return int
   */
  private static function get_carbon_template_post_id( array $fields ): int {
    $raw = $fields['crb_template_block_source'] ?? array();
    if ( ! is_array( $raw ) || empty( $raw ) ) {
      return 0;
    }

    $first = $raw[0];
    if ( is_array( $first ) && isset( $first['id'] ) ) {
      return absint( $first['id'] );
    }

    if ( is_string( $first ) && false !== strpos( $first, ':' ) ) {
      $parts = explode( ':', $first );
      if ( isset( $parts[2] ) ) {
        return absint( $parts[2] );
      }
    }

    return 0;
  }

  /**
   * Field definitions for this block.
   *
   * @return array<int, mixed>
   */
  private static function get_field_definitions(): array {
    return array_merge(
      Abstract_Block::get_block_name_heading_field( __( 'Template Block', CUSTOM_THEME_TEXT_DOMAIN ), 'template' ),
      array(
		  Field::make( 'association', 'crb_template_block_source', __( 'Carbon Template', CUSTOM_THEME_TEXT_DOMAIN ) )
			->set_types(
              array(
				  array(
					  'type'      => 'post',
					  'post_type' => 'carbon_template',
				  ),
			  )
			)
			->set_max( 1 )
			->set_help_text( __( 'Loads another Carbon Template’s block editor content. Global Header/Footer templates and theme Page Templates are not listed.', CUSTOM_THEME_TEXT_DOMAIN ) ),
      )
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
		  'template_post_id' => self::get_carbon_template_post_id( $fields ),
	  ),
      Abstract_Block::map_advanced_fields_to_template_args( $fields )
    );
  }
}
