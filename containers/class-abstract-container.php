<?php
/**
 * Base for Carbon Fields admin containers (theme options, post meta, etc.).
 *
 * @package CustomTheme
 */

namespace CustomTheme\Containers;

/**
 * Contract for theme containers registered with Carbon Fields.
 */
abstract class Abstract_Container {

  /**
   * Register the Carbon Fields container and its fields.
   *
   * @return void
   */
  abstract public static function register(): void;
}
