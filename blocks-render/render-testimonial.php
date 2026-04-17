<?php
/**
 * Testimonials block — markup output.
 *
 * Loaded by {@see \CustomTheme\Blocks\TestimonialBlock::render()}.
 *
 * @package CustomTheme
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

$block_args   = is_array( $args ?? null ) ? $args : array();
$testimonials = isset( $block_args['testimonials'] ) && is_array( $block_args['testimonials'] ) ? $block_args['testimonials'] : array();

ob_start();
?>
<div>
  <?php if ( ! empty( $testimonials ) ) : ?>
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
      <?php foreach ( $testimonials as $item ) : ?>
        <?php
        if ( ! is_array( $item ) ) {
          continue;
        }

        $quote_raw = isset( $item['quote'] ) ? (string) $item['quote'] : '';
        $t_author  = isset( $item['author'] ) ? sanitize_text_field( $item['author'] ) : '';
        $t_role    = isset( $item['author_role'] ) ? sanitize_text_field( $item['author_role'] ) : '';
        $image_id  = isset( $item['image_id'] ) ? absint( $item['image_id'] ) : 0;
        $t_rating  = isset( $item['star_rating'] ) ? absint( $item['star_rating'] ) : 5;
        if ( $t_rating < 1 || $t_rating > 5 ) {
          $t_rating = 5;
        }

        $t_quote = sanitize_textarea_field( $quote_raw );
        if ( '' === $t_quote ) {
          $t_quote = __( 'This team delivered exactly what we needed, on time and with clear communication.', CUSTOM_THEME_TEXT_DOMAIN );
        }

        $rating_aria_label = sprintf(
          /* translators: %d: Number of filled stars (1-5). */
          __( 'Rated %d out of 5 stars', CUSTOM_THEME_TEXT_DOMAIN ),
          $t_rating
        );

        $t_image_html = '';
        if ( $image_id > 0 ) {
          $t_image_html = wp_get_attachment_image(
            $image_id,
            'thumbnail',
            false,
            array(
				'class'   => 'h-16 w-16 shrink-0 rounded-full object-cover ring-2 ring-current ring-opacity-10',
				'loading' => 'lazy',
				'alt'     => '',
            )
          );
        }
        ?>
        <figure class="m-0 flex h-full flex-col rounded-xl border border-current border-opacity-10 bg-white/5 p-6 shadow-sm backdrop-blur-sm sm:p-8">
          <div
            class="mb-3 flex gap-0.5 text-amber-500"
            role="img"
            aria-label="<?php echo esc_attr( $rating_aria_label ); ?>"
          >
            <?php
            for ( $star_index = 1; $star_index <= 5; $star_index++ ) {
              $is_filled = ( $star_index <= $t_rating );
              $symbol    = $is_filled ? '★' : '☆';
              $classes   = $is_filled ? 'text-lg leading-none' : 'text-lg leading-none opacity-40';
              echo '<span class="' . esc_attr( $classes ) . '" aria-hidden="true">' . esc_html( $symbol ) . '</span>';
            }
            ?>
          </div>
          <blockquote class="m-0 flex-1 border-0 p-0">
            <p class="m-0 text-base font-medium leading-relaxed sm:text-lg">
              <?php echo wp_kses_post( nl2br( esc_html( $t_quote ), false ) ); ?>
            </p>
          </blockquote>
          <figcaption class="mt-6 flex items-center gap-4 border-t border-current border-opacity-10 pt-6">
            <?php if ( ! empty( $t_image_html ) ) : ?>
              <?php echo wp_kses_post( $t_image_html ); ?>
            <?php endif; ?>
            <div class="min-w-0 flex-1">
              <?php if ( ! empty( $t_author ) ) : ?>
                <cite class="not-italic">
                  <span class="block text-sm font-semibold sm:text-base"><?php echo esc_html( $t_author ); ?></span>
                </cite>
              <?php endif; ?>
              <?php if ( ! empty( $t_role ) ) : ?>
                <span class="mt-1 block text-xs opacity-90 sm:text-sm"><?php echo esc_html( $t_role ); ?></span>
              <?php endif; ?>
            </div>
          </figcaption>
        </figure>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>
<?php
$inner = ob_get_clean();

$block_args['data_custom_theme_block'] = 'testimonials';
$block_args['inner_html']              = $inner;

get_template_part( 'blocks-render/render-section-container', null, $block_args );
