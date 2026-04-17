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

$block_args  = is_array( $args ?? null ) ? $args : array();
$eyebrow     = isset( $block_args['eyebrow'] ) ? sanitize_text_field( $block_args['eyebrow'] ) : __( 'Custom WordPress Development', CUSTOM_THEME_TEXT_DOMAIN );
$hero_title  = isset( $block_args['title'] ) ? sanitize_text_field( $block_args['title'] ) : __( 'WordPress Custom Fields Library', CUSTOM_THEME_TEXT_DOMAIN );
$description = isset( $block_args['description'] ) ? wp_kses_post( $block_args['description'] ) : __( 'Build repeatable, developer-friendly content sections for modern WordPress websites.', CUSTOM_THEME_TEXT_DOMAIN );
$button_text = isset( $block_args['button_text'] ) ? sanitize_text_field( $block_args['button_text'] ) : __( 'Get Started', CUSTOM_THEME_TEXT_DOMAIN );
$button_url  = isset( $block_args['button_url'] ) ? esc_url_raw( $block_args['button_url'] ) : home_url( '/' );

ob_start();
?>
<div>
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
        class="inline-block rounded border border-current px-4 py-2 no-underline transition focus:underline focus:outline-none focus:ring-2 focus:ring-current focus:ring-offset-2"
        href="<?php echo esc_url( $button_url ); ?>"
      >
        <?php echo esc_html( $button_text ); ?>
      </a>
    </p>
  <?php endif; ?>
</div>
<?php
$inner = ob_get_clean();

$block_args['data_custom_theme_block'] = 'above-the-fold-content';
$block_args['inner_html']              = $inner;

get_template_part( 'blocks-render/render-section-container', null, $block_args );
