<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Independent Publisher
 * @since   Independent Publisher 1.0
 */

if ( ! function_exists( 'independent_publisher_content_nav' ) ) :
	/**
	 * Display navigation to next/previous pages when applicable
	 *
	 * @since Independent Publisher 1.0
	 */
	function independent_publisher_content_nav( $nav_id ) {
		global $wp_query, $post;

		// Don't print empty markup on single pages if there's nowhere to navigate.
		if ( is_single() ) {
			$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
			$next     = get_adjacent_post( false, '', false );

			if ( ! $next && ! $previous )
				return;
		}

		// Don't print empty markup in archives if there's only one page.
		if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) )
			return;

		$nav_class = 'site-navigation paging-navigation';
		if ( is_single() )
			$nav_class = 'site-navigation post-navigation';

		?>
		<nav role="navigation" id="<?php echo $nav_id; ?>" class="<?php echo $nav_class; ?>">
			<h1 class="assistive-text"><?php _e( 'Post navigation', 'independent_publisher' ); ?></h1>

			<?php if ( is_single() ) : // navigation links for single posts ?>

				<?php previous_post_link( '<div class="nav-previous">%link</div>', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'independent_publisher' ) . '</span> %title' ); ?>
				<?php next_post_link( '<div class="nav-next">%link</div>', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'independent_publisher' ) . '</span>' ); ?>

			<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>

				<?php if ( get_next_posts_link() ) : ?>
					<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'independent_publisher' ) ); ?></div>
				<?php endif; ?>

				<?php if ( get_previous_posts_link() ) : ?>
					<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'independent_publisher' ) ); ?></div>
				<?php endif; ?>

			<?php endif; ?>

		</nav><!-- #<?php echo $nav_id; ?> -->
	<?php
	}
endif; // independent_publisher_content_nav

if ( ! function_exists( 'independent_publisher_comment' ) ) :
	/**
	 * Template for comments and pingbacks.
	 *
	 * Used as a callback by wp_list_comments() for displaying the comments.
	 *
	 * @since Independent Publisher 1.0
	 */
	function independent_publisher_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		if ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ) : ?>
			<li class="post pingback">
			<p><?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'independent_publisher' ), ' ' ); ?></p>
		<?php else : ?>
			<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
			<article id="comment-<?php comment_ID(); ?>" class="comment">
				<footer>
					<div class="comment-author vcard">
						<?php echo get_avatar( $comment, 40 ); ?>
						<?php printf( __( '%s <span class="says">says:</span>', 'independent_publisher' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
					</div>
					<!-- .comment-author .vcard -->
					<?php if ( $comment->comment_approved == '0' ) : ?>
						<em><?php _e( 'Your comment is awaiting moderation.', 'independent_publisher' ); ?></em>
						<br />
					<?php endif; ?>

					<div class="comment-meta commentmetadata">
						<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
							<time pubdate datetime="<?php comment_time( 'c' ); ?>">
								<?php
								/* translators: 1: date */
								printf( __( '%1$s', 'independent_publisher' ), get_comment_date() ); ?>
							</time>
						</a>
						<?php edit_comment_link( __( '(Edit)', 'independent_publisher' ), ' ' );
						?>
					</div>
					<!-- .comment-meta .commentmetadata -->
				</footer>

				<div class="comment-content"><?php comment_text(); ?></div>

				<div class="reply">
					<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
				</div>
				<!-- .reply -->
			</article><!-- #comment-## -->

		<?php
		endif;
	}
endif; // ends check for independent_publisher_comment()

if ( ! function_exists( 'independent_publisher_ping' ) ) :
	/**
	 * Template for pingbacks.
	 *
	 * Used as a callback by wp_list_comments() for displaying the pings.
	 *
	 * @since Independent Publisher 1.0
	 */
	function independent_publisher_ping( $comment ) {
		$GLOBALS['comment'] = $comment; ?>
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
		<?php printf( __( '<cite class="fn">%s</cite>' ), get_comment_author_link() ) ?>
		<span> <?php printf( __( '%1$s ' ), get_comment_date( "Y-m-d" ), get_comment_time( "H:i:s" ) ) ?> <?php edit_comment_link( __( '(Edit)' ), '  ', '' ) ?></span>
	<?php
	}
endif; // ends check for independent_publisher_ping()

if ( ! function_exists( 'independent_publisher_posted_author' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 *
	 * @since Independent Publisher 1.0
	 */
	function independent_publisher_posted_author() {
		printf( __( '<span class="byline"><span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span></span>', 'independent_publisher' ),
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_attr( sprintf( __( 'View all posts by %s', 'independent_publisher' ), get_the_author() ) ),
			esc_html( get_the_author() )
		);
	}
endif;

if ( ! function_exists( 'independent_publisher_posted_on_date' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 *
	 * @since Independent Publisher 1.0
	 */
	function independent_publisher_posted_on_date() {
		printf( __( '<a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a>', 'independent_publisher' ),
			esc_url( get_permalink() ),
			esc_attr( get_the_time() ),
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() )
		);
	}
endif;

if ( ! function_exists( 'get_ncl_location' ) ) :
	/**
	 * Returns location information supplied by Nomad Current Location plugin
	 */
	function get_ncl_location( $prefix = "" ) {

		$location = get_post_meta( get_the_ID(), 'ncl_current_location', TRUE );

		if ( trim( $location ) != "" ) {
			return $location_html = $prefix . '<span class="mapThis" place="' . $location . '" zoom="2">' . $location . '</span>';
		}
		else {
			return $location_html = '';
		}
	}
endif;


/**
 * Returns true if a blog has more than 1 category
 *
 * @since Independent Publisher 1.0
 */
function independent_publisher_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {
		// Create an array of all the categories that are attached to posts
		$all_the_cool_cats = get_categories( array(
			'hide_empty' => 1,
		) );

		// Count the number of categories that are attached to the posts
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'all_the_cool_cats', $all_the_cool_cats );
	}

	if ( '1' != $all_the_cool_cats ) {
		// This blog has more than 1 category so independent_publisher_categorized_blog should return true
		return true;
	}
	else {
		// This blog has only 1 category so independent_publisher_categorized_blog should return false
		return false;
	}
}

/**
 * Flush out the transients used in independent_publisher_categorized_blog
 *
 * @since Independent Publisher 1.0
 */
function independent_publisher_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'all_the_cool_cats' );
}

add_action( 'edit_category', 'independent_publisher_category_transient_flusher' );
add_action( 'save_post', 'independent_publisher_category_transient_flusher' );

/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 *
 * @since Independent Publisher 1.2.1
 */
function independent_publisher_wp_title( $title, $sep ) {
	global $page, $paged;

	if ( is_feed() )
		return $title;

	// Add the blog name
	$title .= get_bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title .= " $sep $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		$title .= " $sep " . sprintf( __( 'Page %s', 'independent_publisher' ), max( $paged, $page ) );

	return $title;
}

add_filter( 'wp_title', 'independent_publisher_wp_title', 10, 2 );


/**
 * Returns categories for current post with separator.
 * Optionally returns only a single category.
 *
 * @since Independent Publisher 1.0
 */
function independent_publisher_post_categories( $separator = ',', $single = FALSE ) {
	$categories = get_the_category();
	$output     = '';
	if ( $categories ) {
		foreach ( $categories as $category ) {
			$output .= '<a href="' . get_category_link( $category->term_id ) . '" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $category->name ) ) . '">' . $category->cat_name . '</a>' . $separator;
			if ( $single )
				break;
		}
	}
	return $output;
}

/**
 * Displays sharing buttons
 */
if ( ! function_exists( 'independent_publisher_sharing_buttons' ) ) :
	function independent_publisher_sharing_buttons() {

		// the_title_attribute() returns title with "Aside: " prepended.
		// This removes that so social shares only include the title.
		$dirty_title                          = the_title_attribute( 'echo=0' );
		$clean_title                          = str_replace( 'Aside: ', '', $dirty_title );
		$independent_publisher_social_options = get_option( 'independent_publisher_theme_social_options' );
		?>
		<!-- START SHARING BUTTONS -->
		<div class="social-buttons">
			<a target="_new" href="https://twitter.com/share?text=<?php echo $clean_title; ?><?php echo $independent_publisher_social_options['twitter'] ? '%20via%20' . $independent_publisher_social_options['twitter'] : ''; ?>&url=<?php the_permalink(); ?>" title="Share '<?php echo $clean_title; ?>' on Twitter" onclick="share_button_popup(this.href); return false;"><i class="icon-twitter"></i></a>
			<a target="_new" href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>" title="Share '<?php echo $clean_title; ?>' on Facebook" onclick="share_button_popup(this.href); return false;"><i class="icon-facebook-sign"></i></a>
			<a target="_new" href="https://plusone.google.com/_/+1/confirm?hl=en&url=<?php the_permalink(); ?>" title="Share '<?php echo $clean_title; ?>' on Google+" onclick="share_button_popup(this.href); return false;"><i class="icon-google-plus-sign"></i></a>
		</div>
		<!-- END SHARING BUTTONS -->

	<?php
	}
endif;