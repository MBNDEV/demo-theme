<?php
/**
 * Above the fold block — markup output.
 *
 * Loaded by {@see \CustomTheme\Blocks\AboveTheFoldBlock::render()}.
 *
 * @package CustomTheme
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

$block_args        = is_array( $args ?? null ) ? $args : array();
$eyebrow           = isset( $block_args['eyebrow'] ) ? sanitize_text_field( $block_args['eyebrow'] ) : __( 'Custom WordPress Development', 'custom-theme' );
$hero_title        = isset( $block_args['title'] ) ? sanitize_text_field( $block_args['title'] ) : __( 'WordPress Custom Fields Library', 'custom-theme' );
$description       = isset( $block_args['description'] ) ? wp_kses_post( $block_args['description'] ) : __( 'Build repeatable, developer-friendly content sections for modern WordPress websites.', 'custom-theme' );
$button_text       = isset( $block_args['button_text'] ) ? sanitize_text_field( $block_args['button_text'] ) : __( 'Get Started', 'custom-theme' );
$button_url        = isset( $block_args['button_url'] ) ? esc_url_raw( $block_args['button_url'] ) : home_url( '/' );
$background_color  = isset( $block_args['background_color'] ) ? sanitize_hex_color( $block_args['background_color'] ) : '';
$text_color        = isset( $block_args['text_color'] ) ? sanitize_hex_color( $block_args['text_color'] ) : '';
$fullwidth_section = ! empty( $block_args['fullwidth_section'] );

$style_vars  = '--cbb-bg:' . ( ! empty( $background_color ) ? $background_color : 'transparent' ) . ';';
$style_vars .= '--cbb-fg:' . ( ! empty( $text_color ) ? $text_color : 'inherit' ) . ';';

$section_classes = array(
	'bg-[var(--cbb-bg,transparent)]',
	'text-[var(--cbb-fg,inherit)]',
	'px-4',
	'py-8',
	'sm:px-8',
	'sm:py-12',
	'md:px-12',
);
if ( $fullwidth_section ) {
  $section_classes[] = 'w-full';
} else {
  $section_classes[] = 'container mx-auto';
}
?>
<section
  class="<?php echo esc_attr( implode( ' ', $section_classes ) ); ?>"
  data-custom-theme-block="above-the-fold-content"
  style="<?php echo esc_attr( $style_vars ); ?>"
>
  <div class="mx-auto max-w-3xl">
    <p class="m-0 mb-3 text-sm font-medium uppercase tracking-wide opacity-[0.85]">
      <?php echo esc_html( $eyebrow ); ?>
    </p>
    <h1 class="m-0 mb-4 text-3xl font-semibold leading-tight sm:text-4xl">
      <?php echo esc_html( $hero_title ); ?>
    </h1>
    <div class="mb-6 text-base leading-relaxed [&_p]:m-0 [&_p+_p]:mt-3">
      <?php echo wp_kses_post( wpautop( $description ) ); ?>
    </div>
    <?php if ( ! empty( $button_text ) && ! empty( $button_url ) ) : ?>
      <p class="m-0">
        <a
          class="inline-block rounded border border-current px-4 py-2 no-underline transition focus:underline focus:outline-none focus:ring-2 focus:ring-current focus:ring-offset-2 focus:ring-offset-[var(--cbb-bg)]"
          href="<?php echo esc_url( $button_url ); ?>"
        >
          <?php echo esc_html( $button_text ); ?>
        </a>
      </p>
    <?php endif; ?>
  </div>
</section>
