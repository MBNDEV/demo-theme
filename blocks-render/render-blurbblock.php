<?php
/**
 * Blurb block — markup output.
 *
 * Loaded by {@see \CustomTheme\Blocks\BlurbBlock::render()}.
 *
 * @package CustomTheme
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

$block_args        = is_array( $args ?? null ) ? $args : array();
$image_id          = isset( $block_args['image_id'] ) ? absint( $block_args['image_id'] ) : 0;
$text              = isset( $block_args['text'] ) ? sanitize_text_field( $block_args['text'] ) : __( 'Feature blurb text goes here.', 'custom-theme' );
$background_color  = isset( $block_args['background_color'] ) ? sanitize_hex_color( $block_args['background_color'] ) : '';
$text_color        = isset( $block_args['text_color'] ) ? sanitize_hex_color( $block_args['text_color'] ) : '';
$fullwidth_section = ! empty( $block_args['fullwidth_section'] );

$image_html = '';
if ( $image_id > 0 ) {
  $image_html = wp_get_attachment_image(
    $image_id,
    'large',
    false,
    array(
		'class'   => 'h-auto w-full max-w-xs rounded-lg object-cover sm:max-w-sm',
		'loading' => 'lazy',
		'alt'     => '',
    )
  );
}

$style_vars  = '--cbb-bg:' . ( ! empty( $background_color ) ? $background_color : 'transparent' ) . ';';
$style_vars .= '--cbb-fg:' . ( ! empty( $text_color ) ? $text_color : 'inherit' ) . ';';

$section_classes = array(
	'bg-[var(--cbb-bg,transparent)]',
	'text-[var(--cbb-fg,inherit)]',
	'px-4',
	'py-8',
	'sm:px-8',
);
if ( $fullwidth_section ) {
  $section_classes[] = 'w-full';
} else {
  $section_classes[] = 'container';
}
?>
<section
  class="<?php echo esc_attr( implode( ' ', $section_classes ) ); ?>"
  data-custom-theme-block="blurb"
  style="<?php echo esc_attr( $style_vars ); ?>"
>
  <div class="mx-auto flex max-w-3xl flex-col gap-6 sm:flex-row sm:items-center sm:gap-8">
    <?php if ( ! empty( $image_html ) ) : ?>
      <div class="shrink-0">
        <?php echo wp_kses_post( $image_html ); ?>
      </div>
    <?php endif; ?>
    <p class="m-0 flex-1 text-base leading-relaxed"><?php echo esc_html( $text ); ?></p>
  </div>
</section>
