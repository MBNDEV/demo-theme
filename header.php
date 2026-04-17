<?php
/**
 * Theme header template.
 *
 * Site chrome: Carbon Template post Header Template (slug header-template) — block editor
 * content. Custom HTML (Head / Before Body) from
 * inc/includes-html-injection.php runs via hooks.
 *
 * @package CustomTheme
 */

$custom_theme_global_header_html = custom_theme_get_global_header_template_output_html();
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<header id="masthead" class="site-header">
		<?php if ( '' !== $custom_theme_global_header_html ) : ?>
			<?php echo $custom_theme_global_header_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- HTML from the_content / blocks. ?>
		<?php endif; ?>
	</header>
