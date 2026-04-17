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

$block_args    = is_array( $args ?? null ) ? $args : array();
$gallery_title = isset( $block_args['title'] ) ? sanitize_text_field( $block_args['title'] ) : __( 'Gallery Grid', CUSTOM_THEME_TEXT_DOMAIN );
$raw_image_ids = isset( $block_args['image_ids'] ) && is_array( $block_args['image_ids'] ) ? $block_args['image_ids'] : array();

$image_ids = array_values(
  array_filter(
    array_map( 'absint', $raw_image_ids ),
    static function ( int $image_id ): bool {
      return $image_id > 0;
    }
  )
);

ob_start();
?>
<div>
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
<?php
$inner = ob_get_clean();

$block_args['data_custom_theme_block'] = 'gallery-grid-tailwind';
$block_args['inner_html']              = $inner;

get_template_part( 'blocks-render/render-section-container', null, $block_args );
