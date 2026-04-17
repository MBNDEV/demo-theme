<?php
/**
 * Reusable Section block — section shell + inner blocks output.
 *
 * Loaded by {@see \CustomTheme\Blocks\ReusableSectionBlock::render()}.
 *
 * @package CustomTheme
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

$block_args = is_array( $args ?? null ) ? $args : array();

get_template_part( 'blocks-render/render-section-container', null, $block_args );
