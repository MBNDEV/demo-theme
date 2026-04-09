<?php
/**
 * Carbon Fields: boot, blocks/containers discovery, and registration.
 *
 * @package CustomTheme
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

/**
 * Boot Carbon Fields.
 *
 * @return void
 */
function custom_theme_boot_carbon_fields() {
  \Carbon_Fields\Carbon_Fields::boot();
}
add_action( 'after_setup_theme', 'custom_theme_boot_carbon_fields' );

/**
 * Load all `class-*.php` files in a theme directory (except the abstract base) and
 * return concrete classes that extend a given parent.
 *
 * New modules only need a new file + class; no change to this file.
 * Composer classmap (see composer.json) remains useful for references elsewhere; at
 * runtime, `require_once` ensures newly added files register without `composer dump-autoload`.
 *
 * @param string $theme_relative_dir Theme-relative directory (e.g. `blocks`, `containers`).
 * @param string $abstract_basename  Filename of the abstract base class file to skip.
 * @param string $parent_class       Fully qualified parent class name.
 * @param string $namespace_prefix   Namespace prefix (e.g. `CustomTheme\Blocks\`).
 *
 * @return array<int, class-string>
 */
function custom_theme_discover_concrete_subclasses(
    string $theme_relative_dir,
    string $abstract_basename,
    string $parent_class,
    string $namespace_prefix
): array {
  if ( ! class_exists( $parent_class, true ) ) {
    return array();
  }

  $directory = get_theme_file_path( $theme_relative_dir );
  $pattern   = trailingslashit( $directory ) . 'class-*.php';
  $files     = glob( $pattern );

  if ( false === $files ) {
    return array();
  }

  foreach ( $files as $file ) {
    if ( basename( $file ) === $abstract_basename ) {
      continue;
    }
    require_once $file;
  }

  $classes = array();

  foreach ( get_declared_classes() as $class_name ) {
    if ( strpos( $class_name, $namespace_prefix ) !== 0 ) {
      continue;
    }
    if ( ! is_subclass_of( $class_name, $parent_class, true ) ) {
      continue;
    }
    $reflection = new \ReflectionClass( $class_name );
    if ( $reflection->isAbstract() ) {
      continue;
    }
    $classes[] = $class_name;
  }

  return $classes;
}

/**
 * Discover Carbon Fields Gutenberg block module classes under `blocks/`.
 *
 * @return array<int, class-string<\CustomTheme\Blocks\Abstract_Block>>
 */
function custom_theme_get_block_module_classes(): array {
  return custom_theme_discover_concrete_subclasses(
    'blocks',
    'class-abstract-block.php',
    \CustomTheme\Blocks\Abstract_Block::class,
    'CustomTheme\\Blocks\\'
  );
}

/**
 * Discover Carbon Fields container module classes under `containers/`.
 *
 * @return array<int, class-string<\CustomTheme\Containers\Abstract_Container>>
 */
function custom_theme_get_container_module_classes(): array {
  return custom_theme_discover_concrete_subclasses(
    'containers',
    'class-abstract-container.php',
    \CustomTheme\Containers\Abstract_Container::class,
    'CustomTheme\\Containers\\'
  );
}

/**
 * Register all Carbon Fields blocks from theme modules.
 *
 * @return void
 */
function custom_theme_register_carbon_block_modules(): void {
  foreach ( custom_theme_get_block_module_classes() as $block_class ) {
    $block_class::register();
  }
}

/**
 * Register all Carbon Fields containers from theme modules.
 *
 * @return void
 */
function custom_theme_register_carbon_container_modules(): void {
  foreach ( custom_theme_get_container_module_classes() as $container_class ) {
    $container_class::register();
  }
}

/**
 * Register Carbon Fields blocks and containers.
 *
 * @return void
 */
function custom_theme_register_carbon_fields_modules(): void {
  custom_theme_register_carbon_block_modules();
  custom_theme_register_carbon_container_modules();
}
add_action( 'carbon_fields_register_fields', 'custom_theme_register_carbon_fields_modules' );
