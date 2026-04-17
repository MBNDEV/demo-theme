<?php
/**
 * Delegates to {@see custom_theme_render_block_section_shell()}.
 *
 * Pass merged block args plus `inner_html` (markup inside the inner container).
 *
 * @package CustomTheme
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

$block_args = is_array( $args ?? null ) ? $args : array();
$inner_html = isset( $block_args['inner_html'] ) ? (string) $block_args['inner_html'] : '';
unset( $block_args['inner_html'] );

custom_theme_render_block_section_shell( $block_args, $inner_html );
