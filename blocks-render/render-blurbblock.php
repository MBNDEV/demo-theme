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

$block_args = is_array( $args ?? null ) ? $args : array();
$image_id   = isset( $block_args['image_id'] ) ? absint( $block_args['image_id'] ) : 0;
$text       = isset( $block_args['text'] ) ? sanitize_text_field( $block_args['text'] ) : __( 'Feature blurb text goes here.', CUSTOM_THEME_TEXT_DOMAIN );

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

ob_start();
?>
<div>
  <div class="mx-auto flex max-w-3xl flex-col gap-6 sm:flex-row sm:items-center sm:gap-8">
    <?php if ( ! empty( $image_html ) ) : ?>
      <div class="shrink-0">
        <?php echo wp_kses_post( $image_html ); ?>
      </div>
    <?php endif; ?>
    <p class="m-0 flex-1 text-base leading-relaxed"><?php echo esc_html( $text ); ?></p>
  </div>
</div>
<?php
$inner = ob_get_clean();

$block_args['data_custom_theme_block'] = 'blurb';
$block_args['inner_html']              = $inner;

get_template_part( 'blocks-render/render-section-container', null, $block_args );
