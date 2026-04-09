<?php
/**
 * Base for Carbon Fields Gutenberg block modules.
 *
 * @package CustomTheme
 */

namespace CustomTheme\Blocks;

/**
 * Contract for theme blocks registered with Carbon Fields.
 */
abstract class Abstract_Block {

  /**
   * Register the Carbon Fields block container.
   *
   * @return void
   */
  abstract public static function register(): void;
}
