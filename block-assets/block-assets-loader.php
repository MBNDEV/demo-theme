<?php
/**
 * Per-block JS: register handles and enqueue only when the block appears in content.
 * Block CSS is bundled via Tailwind (`assets/build/tailwind.css`; see resources/css/app.css).
 *
 * @package CustomTheme
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

/**
 * Register script handles for all discovered block modules.
 *
 * @return void
 */
function custom_theme_register_all_block_asset_handles(): void {
  foreach ( custom_theme_get_block_module_classes() as $block_class ) {
    if ( ! is_subclass_of( $block_class, \CustomTheme\Blocks\Abstract_Block::class ) ) {
      continue;
    }
    $block_class::register_assets();
  }
}
add_action( 'init', 'custom_theme_register_all_block_asset_handles', 5 );

/**
 * Defer block asset scripts on the front end and in the block editor (non-blocking parse).
 *
 * @param string $tag    Full script tag HTML.
 * @param string $handle Registered script handle.
 * @param string $src    Script source URL (unused; required by `script_loader_tag` signature).
 * @return string
 */
function custom_theme_defer_block_asset_scripts( string $tag, string $handle, string $src ): string {
  unset( $src );

  if ( ! preg_match( '/^custom-theme-bk-.+-js$/', $handle ) ) {
    return $tag;
  }
  if ( preg_match( '/\s(?:defer|async)(\s|=|>)/i', $tag ) ) {
    return $tag;
  }

  return (string) preg_replace( '/<script\s/i', '<script defer ', $tag, 1 );
}
add_filter( 'script_loader_tag', 'custom_theme_defer_block_asset_scripts', 10, 3 );

/**
 * Whether the current singular main post contains a given block name.
 *
 * @param string $block_name Full name, e.g. carbon-fields/blurb.
 * @return bool
 */
function custom_theme_post_has_block_name( string $block_name ): bool {
  if ( ! is_singular() ) {
    return false;
  }

  $post = get_queried_object();
  if ( ! $post instanceof \WP_Post ) {
    return false;
  }

  return has_block( $block_name, $post );
}

/**
 * Enqueue registered block assets only when the block is used in the main queried post.
 *
 * @return void
 */
function custom_theme_enqueue_block_assets_for_singular_content(): void {
  if ( is_admin() ) {
    return;
  }

  foreach ( custom_theme_get_block_module_classes() as $block_class ) {
    if ( ! is_subclass_of( $block_class, \CustomTheme\Blocks\Abstract_Block::class ) ) {
      continue;
    }
    if ( ! custom_theme_post_has_block_name( $block_class::get_wp_block_name() ) ) {
      continue;
    }
    if ( wp_script_is( $block_class::get_script_handle(), 'registered' ) ) {
      wp_enqueue_script( $block_class::get_script_handle() );
    }
  }
}
add_action( 'wp_enqueue_scripts', 'custom_theme_enqueue_block_assets_for_singular_content', 20 );

/**
 * Enqueue all block assets in the block editor so previews match the front.
 *
 * @return void
 */
function custom_theme_enqueue_block_assets_for_editor(): void {
  foreach ( custom_theme_get_block_module_classes() as $block_class ) {
    if ( ! is_subclass_of( $block_class, \CustomTheme\Blocks\Abstract_Block::class ) ) {
      continue;
    }
    if ( wp_script_is( $block_class::get_script_handle(), 'registered' ) ) {
      wp_enqueue_script( $block_class::get_script_handle() );
    }
  }
}
add_action( 'enqueue_block_editor_assets', 'custom_theme_enqueue_block_assets_for_editor' );
