<?php
/**
 * Base for Carbon Fields Gutenberg block modules.
 *
 * @package CustomTheme
 */

namespace CustomTheme\Blocks;

use Carbon_Fields\Field;

/**
 * Contract for theme blocks registered with Carbon Fields.
 */
abstract class Abstract_Block {

  /**
   * Shared Carbon field name: full-bleed section vs constrained container.
   */
  public const FULLWIDTH_SECTION_FIELD = 'crb_block_fullwidth_section';

  /**
   * Register the Carbon Fields block container.
   *
   * @return void
   */
  abstract public static function register(): void;

  /**
   * Advanced options appended to every block (separator + Fullwidth Section).
   *
   * @return array<int, mixed>
   */
  public static function get_advanced_field_definitions(): array {
    return array(
		Field::make( 'separator', 'crb_block_advanced_sep', __( 'Advanced options', 'custom-theme' ) ),
		Field::make( 'checkbox', self::FULLWIDTH_SECTION_FIELD, __( 'Fullwidth Section', 'custom-theme' ) ),
    );
  }

  /**
   * Map shared advanced fields into template arguments.
   *
   * @param array<string, mixed> $fields Raw Carbon field values.
   * @return array{fullwidth_section: bool}
   */
  public static function map_advanced_fields_to_template_args( array $fields ): array {
    $raw = $fields[ self::FULLWIDTH_SECTION_FIELD ] ?? '';

    return array(
		'fullwidth_section' => ( 'yes' === $raw ),
    );
  }
}
