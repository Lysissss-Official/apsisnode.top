<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of #main and all content
 * after. Calls sidebar-footer.php for bottom widgets.
 *
 * @package Bravada
 */

?>
		<?php cryout_absolute_bottom_hook(); ?>

		<aside id="colophon" <?php cryout_schema_microdata( 'sidebar' );?>>
			<div id="colophon-inside" <?php bravada_footer_colophon_class();?>>
				<?php get_sidebar( 'footer' );?>
			</div>
		</aside><!-- #colophon -->

	</div><!-- #main -->

	<footer id="footer" class="cryout" <?php cryout_schema_microdata( 'footer' );?>>
		<?php cryout_master_topfooter_hook(); ?>
		<div id="footer-top">
			<div class="footer-inside">
				<?php cryout_master_footer_hook(); ?>
			</div><!-- #footer-inside -->
		</div><!-- #footer-top -->
		<div id="footer-bottom">
			<div class="footer-inside">
				 <div style="display:block; margin: 0.5em auto;"><a target="_blank" href="https://wordpress.org/">WordPress</a> 平台 · <a target="_blank" href="https://apsisnode.top">ApsisUI 0</a> 主题</div>
			</div> <!-- #footer-inside -->
		</div><!-- #footer-bottom -->
	</footer>
</div><!-- site-wrapper -->
	<?php wp_footer(); ?>
</body>
</html>
