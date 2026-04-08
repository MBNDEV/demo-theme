<?php
/**
 * Blurb block template.
 *
 * Usage:
 * get_template_part(
 *   'blocks/blurb',
 *   null,
 *   array(
 *     'image_id' => 0,
 *     'text'     => 'Feature blurb text goes here.',
 *   )
 * );
 *
 * @package CustomTheme
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

$block_args       = is_array( $args ?? null ) ? $args : array();
$image_id         = isset( $block_args['image_id'] ) ? absint( $block_args['image_id'] ) : 0;
$text             = isset( $block_args['text'] ) ? sanitize_text_field( $block_args['text'] ) : __( 'Feature blurb text goes here.', 'custom-theme' );
$background_color = isset( $block_args['background_color'] ) ? sanitize_hex_color( $block_args['background_color'] ) : '';
$text_color       = isset( $block_args['text_color'] ) ? sanitize_hex_color( $block_args['text_color'] ) : '';

$image_html = '';
if ( $image_id > 0 ) {
  $image_html = wp_get_attachment_image(
    $image_id,
    'large',
    false,
    array(
		'class'   => 'block-blurb__image',
		'loading' => 'lazy',
		'alt'     => '',
    )
  );
}

$section_styles = '';
if ( ! empty( $background_color ) ) {
  $section_styles .= 'background-color:' . $background_color . ';';
}
if ( ! empty( $text_color ) ) {
  $section_styles .= 'color:' . $text_color . ';';
}
?>
<section class="block block-blurb"<?php echo ! empty( $section_styles ) ? ' style="' . esc_attr( $section_styles ) . '"' : ''; ?>>
  <div class="block-blurb__inner">
    <?php if ( ! empty( $image_html ) ) : ?>
      <div class="block-blurb__media">
        <?php echo wp_kses_post( $image_html ); ?>
      </div>
    <?php endif; ?>
    <p class="block-blurb__text"><?php echo esc_html( $text ); ?></p>
  </div>
</section>
