<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package Independent Publisher
 * @since   Independent Publisher 1.0
 */
?>

</div><!-- #main .site-main -->

<footer id="colophon" class="site-footer" role="contentinfo">
	<div class="site-info">
		<?php do_action( 'independent_publisher_credits' ); ?>
	</div>
	<!-- .site-info -->
</footer><!-- #colophon .site-footer -->
</div><!-- #page .hfeed .site -->

<?php wp_footer(); ?>

</body>
</html>
