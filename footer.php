<?php
/**
 * Theme footer template.
 *
 * Site chrome: Carbon Template post Footer Template (slug footer-template) — block editor
 * content. Custom HTML (After Body / Footer) from
 * inc/includes-html-injection.php runs via hooks.
 *
 * @package CustomTheme
 */

$custom_theme_global_footer_html = custom_theme_get_global_footer_template_output_html();
?>
	<footer class="site-footer">
		<?php if ( '' !== $custom_theme_global_footer_html ) : ?>
			<?php echo $custom_theme_global_footer_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- HTML from the_content / blocks. ?>
		<?php endif; ?>
	</footer>
</div>
<?php do_action( 'custom_theme_after_body' ); ?>
<?php wp_footer(); ?>
</body>
</html>
