<?php
/**
 * Gallery Grid Tailwind block — markup output.
 *
 * Loaded by {@see \CustomTheme\Blocks\GalleryGridTailwind::render()}.
 *
 * @package CustomTheme
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

$block_args        = is_array( $args ?? null ) ? $args : array();
$gallery_title     = isset( $block_args['title'] ) ? sanitize_text_field( $block_args['title'] ) : __( 'Gallery Grid', 'custom-theme' );
$raw_image_ids     = isset( $block_args['image_ids'] ) && is_array( $block_args['image_ids'] ) ? $block_args['image_ids'] : array();
$background_color  = isset( $block_args['background_color'] ) ? sanitize_hex_color( $block_args['background_color'] ) : '';
$text_color        = isset( $block_args['text_color'] ) ? sanitize_hex_color( $block_args['text_color'] ) : '';
$fullwidth_section = ! empty( $block_args['fullwidth_section'] );

$image_ids = array_values(
  array_filter(
    array_map( 'absint', $raw_image_ids ),
    static function ( int $image_id ): bool {
      return $image_id > 0;
    }
  )
);

$style_vars  = '--cbb-bg:' . ( ! empty( $background_color ) ? $background_color : 'transparent' ) . ';';
$style_vars .= '--cbb-fg:' . ( ! empty( $text_color ) ? $text_color : 'inherit' ) . ';';

$section_classes = array(
	'bg-[var(--cbb-bg,transparent)]',
	'text-[var(--cbb-fg,inherit)]',
	'px-4',
	'py-8',
	'sm:px-8',
	'sm:py-10',
);

if ( $fullwidth_section ) {
  $section_classes[] = 'w-full';
} else {
  $section_classes[] = 'container mx-auto';
}
?>
<section
  class="<?php echo esc_attr( implode( ' ', $section_classes ) ); ?>"
  data-custom-theme-block="gallery-grid-tailwind"
  style="<?php echo esc_attr( $style_vars ); ?>"
>
  <div class="mx-auto max-w-6xl">
    <?php if ( ! empty( $gallery_title ) ) : ?>
      <h2 class="m-0 mb-6 text-2xl font-semibold leading-tight sm:text-3xl">
        <?php echo esc_html( $gallery_title ); ?>
      </h2>
    <?php endif; ?>

    <?php if ( ! empty( $image_ids ) ) : ?>
      <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
        <?php foreach ( $image_ids as $image_id ) : ?>
          <?php
          $image_html = wp_get_attachment_image(
            $image_id,
            'large',
            false,
            array(
				'class'   => 'h-64 w-full rounded-lg object-cover',
				'loading' => 'lazy',
            )
          );
          if ( empty( $image_html ) ) {
            continue;
          }
          ?>
          <figure class="m-0 overflow-hidden">
            <?php echo wp_kses_post( $image_html ); ?>
          </figure>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
