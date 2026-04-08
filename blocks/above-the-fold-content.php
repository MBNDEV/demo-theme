<?php
/**
 * Above the fold content block template.
 *
 * Usage:
 * get_template_part(
 *   'blocks/above-the-fold-content',
 *   null,
 *   array(
 *     'eyebrow'     => 'Custom WordPress Development',
 *     'title'       => 'WordPress Custom Fields Library',
 *     'description' => 'Create and manage flexible field groups.',
 *     'button_text' => 'Get Started',
 *     'button_url'  => home_url( '/get-started/' ),
 *   )
 * );
 *
 * @package CustomTheme
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

$block_args       = is_array( $args ?? null ) ? $args : array();
$eyebrow          = isset( $block_args['eyebrow'] ) ? sanitize_text_field( $block_args['eyebrow'] ) : __( 'Custom WordPress Development', 'custom-theme' );
$hero_title       = isset( $block_args['title'] ) ? sanitize_text_field( $block_args['title'] ) : __( 'WordPress Custom Fields Library', 'custom-theme' );
$description      = isset( $block_args['description'] ) ? wp_kses_post( $block_args['description'] ) : __( 'Build repeatable, developer-friendly content sections for modern WordPress websites.', 'custom-theme' );
$button_text      = isset( $block_args['button_text'] ) ? sanitize_text_field( $block_args['button_text'] ) : __( 'Get Started', 'custom-theme' );
$button_url       = isset( $block_args['button_url'] ) ? esc_url_raw( $block_args['button_url'] ) : home_url( '/' );
$background_color = isset( $block_args['background_color'] ) ? sanitize_hex_color( $block_args['background_color'] ) : '';
$text_color       = isset( $block_args['text_color'] ) ? sanitize_hex_color( $block_args['text_color'] ) : '';

$section_styles = '';
if ( ! empty( $background_color ) ) {
  $section_styles .= 'background-color:' . $background_color . ';';
}
if ( ! empty( $text_color ) ) {
  $section_styles .= 'color:' . $text_color . ';';
}
?>
<section class="block block-above-the-fold"<?php echo ! empty( $section_styles ) ? ' style="' . esc_attr( $section_styles ) . '"' : ''; ?>>
  <div class="block-above-the-fold__inner">
    <p class="block-above-the-fold__eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
    <h1 class="block-above-the-fold__title"><?php echo esc_html( $hero_title ); ?></h1>
    <div class="block-above-the-fold__description">
      <?php echo wp_kses_post( wpautop( $description ) ); ?>
    </div>
    <?php if ( ! empty( $button_text ) && ! empty( $button_url ) ) : ?>
      <p class="block-above-the-fold__cta-wrap">
        <a class="block-above-the-fold__cta" href="<?php echo esc_url( $button_url ); ?>">
          <?php echo esc_html( $button_text ); ?>
        </a>
      </p>
    <?php endif; ?>
  </div>
</section>
