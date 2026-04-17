<?php
/**
 * Template block — output Carbon Template main body only.
 *
 * Loaded by {@see \CustomTheme\Blocks\TemplateBlock::render()}.
 *
 * @package CustomTheme
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

$block_args       = is_array( $args ?? null ) ? $args : array();
$template_post_id = isset( $block_args['template_post_id'] ) ? absint( $block_args['template_post_id'] ) : 0;

if ( $template_post_id <= 0 ) {
  return;
}

$post_object = get_post( $template_post_id );
if ( ! $post_object instanceof \WP_Post || 'carbon_template' !== $post_object->post_type || 'publish' !== $post_object->post_status ) {
  return;
}

ob_start();
setup_postdata( $post_object );
// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Block HTML from the_content.
echo apply_filters( 'the_content', $post_object->post_content );
wp_reset_postdata();
$inner = ob_get_clean();

$block_args['data_custom_theme_block'] = 'template';
$block_args['inner_container_classes'] = 'mx-auto container';
$block_args['inner_html']              = $inner;

get_template_part( 'blocks-render/render-section-container', null, $block_args );
