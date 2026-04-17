<?php
/**
 * Singular views (posts, pages, carbon_template, etc.). Used when no single.php / page.php exist.
 *
 * @package CustomTheme
 */

if ( is_singular( 'carbon_template' ) ) {
  require get_theme_file_path( 'page-templates/template-single-carbon.php' );
  return;
}

get_header();
?>
<main id="main" class="site-main">
  <?php
  if ( have_posts() ) :
    while ( have_posts() ) :
      the_post();
      ?>
      <article id="post-<?php the_ID(); ?>" <?php post_class( 'layout-blank' ); ?>>
        <?php the_content(); ?>
      </article>
      <?php
    endwhile;
  else :
    ?>
    <section class="no-results">
      <header class="page-header">
        <h1 class="page-title"><?php esc_html_e( 'Nothing Found', CUSTOM_THEME_TEXT_DOMAIN ); ?></h1>
      </header>
      <div class="page-content">
        <p><?php esc_html_e( 'No content matched your request.', CUSTOM_THEME_TEXT_DOMAIN ); ?></p>
      </div>
    </section>
    <?php
  endif;
  ?>
</main>
<?php
get_template_part( 'widgets/widgets-sidebar' );
get_footer();
