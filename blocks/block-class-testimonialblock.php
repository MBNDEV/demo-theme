<?php
/**
 * Testimonials — Carbon Fields Gutenberg block.
 *
 * @package CustomTheme
 */

namespace CustomTheme\Blocks;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

/**
 * Registers fields and renders multiple testimonials in blocks-render/.
 */
final class TestimonialBlock extends Abstract_Block {

  /**
   * Front assets under block-assets/block-assets-testimonialblock/.
   */
  protected const ASSET_SUBDIR = 'block-assets-testimonialblock';

  /**
   * Handle slug for custom-theme-bk-*-js/css.
   */
  protected const ASSET_HANDLE_SLUG = 'testimonial';

  /**
   * Script only; no block.css in this folder.
   */
  protected const ASSET_HAS_CSS = false;

  /**
   * Must match Carbon's registered block name.
   */
  protected const WP_BLOCK_NAME = 'carbon-fields/testimonials';

  /**
   * Register the block with Carbon Fields.
   *
   * @return void
   */
  public static function register(): void {
    Container::make( 'block', __( 'Testimonials', CUSTOM_THEME_TEXT_DOMAIN ) )
      ->set_icon( 'format-quote' )
      ->set_category( CUSTOM_THEME_BLOCK_CATEGORY, custom_theme_get_theme_blocks_category_title() )
      ->set_render_callback( array( self::class, 'render' ) )
      ->add_fields(
        array_merge(
          Abstract_Block::get_block_name_heading_field( __( 'Testimonial Block', CUSTOM_THEME_TEXT_DOMAIN ), 'testimonial' ),
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
      'blocks-render/render-testimonial',
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
		Field::make( 'complex', 'crb_testimonial_items', __( 'Testimonials', CUSTOM_THEME_TEXT_DOMAIN ) )
		  ->setup_labels(
            array(
				'singular_name' => __( 'Testimonial', CUSTOM_THEME_TEXT_DOMAIN ),
				'plural_name'   => __( 'Testimonials', CUSTOM_THEME_TEXT_DOMAIN ),
			)
		  )
		  ->set_layout( 'tabbed-horizontal' )
		  ->add_fields(
            array(
				Field::make( 'textarea', 'quote', __( 'Quote', CUSTOM_THEME_TEXT_DOMAIN ) )
				  ->set_default_value( __( 'This team delivered exactly what we needed, on time and with clear communication.', CUSTOM_THEME_TEXT_DOMAIN ) ),
				Field::make( 'select', 'star_rating', __( 'Star rating', CUSTOM_THEME_TEXT_DOMAIN ) )
				  ->set_options(
                    array(
						'5' => __( '5 stars', CUSTOM_THEME_TEXT_DOMAIN ),
						'4' => __( '4 stars', CUSTOM_THEME_TEXT_DOMAIN ),
						'3' => __( '3 stars', CUSTOM_THEME_TEXT_DOMAIN ),
						'2' => __( '2 stars', CUSTOM_THEME_TEXT_DOMAIN ),
						'1' => __( '1 star', CUSTOM_THEME_TEXT_DOMAIN ),
					)
				  )
				  ->set_default_value( '5' ),
				Field::make( 'text', 'author', __( 'Author name', CUSTOM_THEME_TEXT_DOMAIN ) )
				  ->set_default_value( __( 'Jane Doe', CUSTOM_THEME_TEXT_DOMAIN ) ),
				Field::make( 'text', 'author_role', __( 'Role or company', CUSTOM_THEME_TEXT_DOMAIN ) )
				  ->set_default_value( __( 'Product Lead, Example Co.', CUSTOM_THEME_TEXT_DOMAIN ) ),
				Field::make( 'image', 'photo', __( 'Photo', CUSTOM_THEME_TEXT_DOMAIN ) )
				  ->set_value_type( 'id' ),
			)
		  )
		  ->set_header_template(
            sprintf(
				  /* translators: %s: sequential tab number (1, 2, …) rendered by Carbon Fields. */
              __( 'Testimonial %s', CUSTOM_THEME_TEXT_DOMAIN ),
              '<%= $_index + 1 %>'
            )
		  ),
    );
  }

  /**
   * Normalize one complex row from the editor into template args.
   *
   * @param array<string, mixed> $row Raw complex entry.
   * @return array{quote: string, star_rating: int, author: string, author_role: string, image_id: int}
   */
  private static function normalize_testimonial_row( array $row ): array {
    $star_rating = 5;
    if ( isset( $row['star_rating'] ) ) {
      $star_rating = absint( $row['star_rating'] );
    }
    if ( $star_rating < 1 || $star_rating > 5 ) {
      $star_rating = 5;
    }

    return array(
		'quote'       => isset( $row['quote'] ) ? (string) $row['quote'] : '',
		'star_rating' => $star_rating,
		'author'      => isset( $row['author'] ) ? (string) $row['author'] : '',
		'author_role' => isset( $row['author_role'] ) ? (string) $row['author_role'] : '',
		'image_id'    => isset( $row['photo'] ) ? absint( $row['photo'] ) : 0,
    );
  }

  /**
   * Map stored field keys to template part arguments.
   *
   * @param array<string, mixed> $fields Raw field values.
   * @return array<string, mixed>
   */
  private static function map_fields_to_template_args( array $fields ): array {
    $testimonials = array();
    $raw_items    = $fields['crb_testimonial_items'] ?? array();

    if ( is_array( $raw_items ) ) {
      foreach ( $raw_items as $row ) {
        if ( is_array( $row ) ) {
          $testimonials[] = self::normalize_testimonial_row( $row );
        }
      }
    }

    return array_merge(
      array(
		  'testimonials' => $testimonials,
	  ),
      Abstract_Block::map_advanced_fields_to_template_args( $fields )
    );
  }
}
