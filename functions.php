<?php

/**
 * Sets up theme defaults and registers the various WordPress features that
 * Twenty Thirteen supports.
 *
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_editor_style() To add a Visual Editor stylesheet.
 * @uses add_theme_support() To add support for automatic feed links, post
 * formats, admin bar, and post thumbnails.
 * @uses register_nav_menu() To add support for a navigation menu.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since Twenty Thirteen 1.0
 *
 * @return void
 */
function larry_setup() {
    /*
     * Makes Twenty Thirteen available for translation.
     *
     * Translations can be added to the /languages/ directory.
     * If you're building a theme based on Twenty Thirteen, use a find and
     * replace to change 'twentythirteen' to the name of your theme in all
     * template files.
     */
    //load_theme_textdomain( 'twentythirteen', get_template_directory() . '/languages' );

    /*
     * This theme styles the visual editor to resemble the theme style,
     * specifically font, colors, and column width.
     */
    //add_editor_style( 'css/editor-style.css' );

    // Adds RSS feed links to <head> for posts and comments.
    add_theme_support( 'automatic-feed-links' );

    /*
     * This theme supports all available post formats.
     * See http://codex.wordpress.org/Post_Formats
     */
    add_theme_support( 'post-formats', array(
        'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video'
    ) );

    // This theme uses wp_nav_menu() in one location.
    function register_my_menu() {
        register_nav_menu('header-menu',__( 'Header Menu' ));
    }

    /*
     * This theme uses a custom image size for featured images, displayed on
     * "standard" posts and pages.
     */
    add_theme_support( 'post-thumbnails' );
    set_post_thumbnail_size( 604, 270, true );

    // This theme uses its own gallery styles.
    add_filter( 'use_default_gallery_style', '__return_false' );
}
add_action( 'after_setup_theme', 'larry_setup' );


// Generates semantic classes for BODY element
function larry_body_class( $print = true ) {
	global $wp_query, $current_user;

	// It's surely a WordPress blog, right?
	$c = array('wp');

	// Applies the time- and date-based classes (below) to BODY element
	sandbox_date_classes( time(), $c );

	// Generic semantic classes for what type of content is displayed
	is_front_page()  ? $c[] = 'home'       : null; // For the front page, if set
	is_home()        ? $c[] = 'blog'       : null; // For the blog posts page, if set
	is_archive()     ? $c[] = 'archive'    : null;
	is_date()        ? $c[] = 'date'       : null;
	is_search()      ? $c[] = 'search'     : null;
	is_paged()       ? $c[] = 'paged'      : null;
	is_attachment()  ? $c[] = 'attachment' : null;
	is_404()         ? $c[] = 'four04'     : null; // CSS does not allow a digit as first character

	// Special classes for BODY element when a single post
	if ( is_single() ) {
		$postID = $wp_query->post->ID;
		the_post();

		// Adds 'single' class and class with the post ID
		$c[] = 'single postid-' . $postID;

		// Adds classes for the month, day, and hour when the post was published
		if ( isset( $wp_query->post->post_date ) )
			sandbox_date_classes( mysql2date( 'U', $wp_query->post->post_date ), $c, 's-' );

		// Adds category classes for each category on single posts
		if ( $cats = get_the_category() )
			foreach ( $cats as $cat )
				$c[] = 's-category-' . $cat->slug;

		// Adds tag classes for each tags on single posts
		if ( $tags = get_the_tags() )
			foreach ( $tags as $tag )
				$c[] = 's-tag-' . $tag->slug;

		// Adds MIME-specific classes for attachments
		if ( is_attachment() ) {
			$mime_type = get_post_mime_type();
			$mime_prefix = array( 'application/', 'image/', 'text/', 'audio/', 'video/', 'music/' );
				$c[] = 'attachmentid-' . $postID . ' attachment-' . str_replace( $mime_prefix, "", "$mime_type" );
		}

		// Adds author class for the post author
		$c[] = 's-author-' . sanitize_title_with_dashes(strtolower(get_the_author_login()));
		rewind_posts();
	}

	// Author name classes for BODY on author archives
	elseif ( is_author() ) {
		$author = $wp_query->get_queried_object();
		$c[] = 'author';
		$c[] = 'author-' . $author->user_nicename;
	}

	// Category name classes for BODY on category archvies
	elseif ( is_category() ) {
		$cat = $wp_query->get_queried_object();
		$c[] = 'category';
		$c[] = 'category-' . $cat->slug;
	}

	// Tag name classes for BODY on tag archives
	elseif ( is_tag() ) {
		$tags = $wp_query->get_queried_object();
		$c[] = 'tag';
		$c[] = 'tag-' . $tags->slug;
	}

	// Page author for BODY on 'pages'
	elseif ( is_page() ) {
		$pageID = $wp_query->post->ID;
		$page_children = wp_list_pages("child_of=$pageID&echo=0");
		the_post();
		$c[] = 'page pageid-' . $pageID;
		$c[] = 'page-author-' . sanitize_title_with_dashes(strtolower(get_the_author('login')));
		// Checks to see if the page has children and/or is a child page; props to Adam
		if ( $page_children )
			$c[] = 'page-parent';
		if ( $wp_query->post->post_parent )
			$c[] = 'page-child parent-pageid-' . $wp_query->post->post_parent;
		if ( is_page_template() ) // Hat tip to Ian, themeshaper.com
			$c[] = 'page-template page-template-' . str_replace( '.php', '-php', get_post_meta( $pageID, '_wp_page_template', true ) );
		rewind_posts();
	}

	// Search classes for results or no results
	elseif ( is_search() ) {
		the_post();
		if ( have_posts() ) {
			$c[] = 'search-results';
		} else {
			$c[] = 'search-no-results';
		}
		rewind_posts();
	}

	// For when a visitor is logged in while browsing
	if ( $current_user->ID )
		$c[] = 'loggedin';

	// Paged classes; for 'page X' classes of index, single, etc.
	if ( ( ( $page = $wp_query->get('paged') ) || ( $page = $wp_query->get('page') ) ) && $page > 1 ) {
		$c[] = 'paged-' . $page;
		if ( is_single() ) {
			$c[] = 'single-paged-' . $page;
		} elseif ( is_page() ) {
			$c[] = 'page-paged-' . $page;
		} elseif ( is_category() ) {
			$c[] = 'category-paged-' . $page;
		} elseif ( is_tag() ) {
			$c[] = 'tag-paged-' . $page;
		} elseif ( is_date() ) {
			$c[] = 'date-paged-' . $page;
		} elseif ( is_author() ) {
			$c[] = 'author-paged-' . $page;
		} elseif ( is_search() ) {
			$c[] = 'search-paged-' . $page;
		}
	}

	// Separates classes with a single space, collates classes for BODY
	$c = join( ' ', apply_filters( 'body_class',  $c ) ); // Available filter: body_class

	// And tada!
	return $print ? print($c) : $c;
}

// Generates semantic classes for each post DIV element
function sandbox_post_class( $print = true ) {
	global $post, $sandbox_post_alt;

	// hentry for hAtom compliace, gets 'alt' for every other post DIV, describes the post type and p[n]
	$c = array( 'hentry', "p$sandbox_post_alt", $post->post_type, $post->post_status );

	// Author for the post queried
	$c[] = 'author-' . sanitize_title_with_dashes(strtolower(get_the_author('login')));

	// Category for the post queried
	foreach ( (array) get_the_category() as $cat )
		$c[] = 'category-' . $cat->slug;

	// Tags for the post queried; if not tagged, use .untagged
	if ( get_the_tags() == null ) {
		$c[] = 'untagged';
	} else {
		foreach ( (array) get_the_tags() as $tag )
			$c[] = 'tag-' . $tag->slug;
	}

	// For password-protected posts
	if ( $post->post_password )
		$c[] = 'protected';

	// Applies the time- and date-based classes (below) to post DIV
	sandbox_date_classes( mysql2date( 'U', $post->post_date ), $c );

	// If it's the other to the every, then add 'alt' class
	if ( ++$sandbox_post_alt % 2 )
		$c[] = 'alt';

	// Separates classes with a single space, collates classes for post DIV
	$c = join( ' ', apply_filters( 'post_class', $c ) ); // Available filter: post_class

	// And tada!
	return $print ? print($c) : $c;
}

// Define the num val for 'alt' classes (in post DIV and comment LI)
$sandbox_post_alt = 1;

// Generates semantic classes for each comment LI element
function sandbox_comment_class( $print = true ) {
	global $comment, $post, $sandbox_comment_alt;

	// Collects the comment type (comment, trackback),
	$c = array( $comment->comment_type );

	// Counts trackbacks (t[n]) or comments (c[n])
	if ( $comment->comment_type == 'comment' ) {
		$c[] = "c$sandbox_comment_alt";
	} else {
		$c[] = "t$sandbox_comment_alt";
	}

	// If the comment author has an id (registered), then print the log in name
	if ( $comment->user_id > 0 ) {
		$user = get_userdata($comment->user_id);
		// For all registered users, 'byuser'; to specificy the registered user, 'commentauthor+[log in name]'
		$c[] = 'byuser comment-author-' . sanitize_title_with_dashes(strtolower( $user->user_login ));
		// For comment authors who are the author of the post
		if ( $comment->user_id === $post->post_author )
			$c[] = 'bypostauthor';
	}

	// If it's the other to the every, then add 'alt' class; collects time- and date-based classes
	sandbox_date_classes( mysql2date( 'U', $comment->comment_date ), $c, 'c-' );
	if ( ++$sandbox_comment_alt % 2 )
		$c[] = 'alt';

	// Separates classes with a single space, collates classes for comment LI
	$c = join( ' ', apply_filters( 'comment_class', $c ) ); // Available filter: comment_class

	// Tada again!
	return $print ? print($c) : $c;
}

// Generates time- and date-based classes for BODY, post DIVs, and comment LIs; relative to GMT (UTC)
function sandbox_date_classes( $t, &$c, $p = '' ) {
	$t = $t + ( get_option('gmt_offset') * 3600 );
	$c[] = $p . 'y' . gmdate( 'Y', $t ); // Year
	$c[] = $p . 'm' . gmdate( 'm', $t ); // Month
	$c[] = $p . 'd' . gmdate( 'd', $t ); // Day
	$c[] = $p . 'h' . gmdate( 'H', $t ); // Hour
}



// Produces an avatar image with the hCard-compliant photo class
function sandbox_commenter_link() {
	$commenter = get_comment_author_link();
	if ( ereg( '<a[^>]* class=[^>]+>', $commenter ) ) {
		$commenter = ereg_replace( '(<a[^>]* class=[\'"]?)', '\\1url ' , $commenter );
	} else {
		$commenter = ereg_replace( '(<a )/', '\\1class="url "' , $commenter );
	}
	$avatar_email = get_comment_author_email();
	$avatar_size = apply_filters( 'avatar_size', '32' ); // Available filter: avatar_size
	$avatar = str_replace( "class='avatar", "class='photo avatar", get_avatar( $avatar_email, $avatar_size ) );
	echo $avatar . ' <span class="fn n">' . $commenter . '</span>';
}



// Adds filters for the description/meta content in archives.php
add_filter( 'archive_meta', 'wptexturize' );
add_filter( 'archive_meta', 'convert_smilies' );
add_filter( 'archive_meta', 'convert_chars' );
add_filter( 'archive_meta', 'wpautop' );

// end sandbox

//begin simple folio


	/* Register Widgets */
		if ( function_exists('register_sidebar') ) {
			register_sidebar(array(
				'name' => 'Sidebar Widget',
				'before_widget' => '<div class="widget %2$s">',
				'after_widget' => '</div>',
				'before_title' => '<h3>',
				'after_title' => '</h3>',
			));
			register_sidebar(array(
				'name' => 'Home Widget',
				'before_widget' => '<div class="columns small-12 large-4 widget %2$s">',
				'after_widget' => '</div>',
				'before_title' => '<h3>',
				'after_title' => '</h3>',
			));
		}

	/* Un-Register WP-PageNavi Style Page Include */
		function my_deregister_styles() {
			wp_deregister_style('wp-pagenavi');
		}
		add_action('wp_print_styles','my_deregister_styles',100);

	/* Function To Limit Output Of Content.*/
		function the_content_limit($max_char, $more_link_text = '(more...)', $stripteaser = 0, $more_file = '') {
			$content = get_the_content($more_link_text, $stripteaser, $more_file);
			$content = apply_filters('the_content', $content);
			$content = str_replace(']]>', ']]&gt;', $content);
			$content = strip_tags($content);

		   if (strlen($_GET['p']) > 0) {
			  echo $content;
		   }
		   else if ((strlen($content)>$max_char) && ($espacio = strpos($content, " ", $max_char ))) {
				$content = substr($content, 0, $espacio);
				$content = $content;
				echo $content;
				echo "...";
		   }
		   else {
			  echo $content;
		   }
		}

	/* Exclude Portfolio Category & Child Categories From Blog Posts */
		function sf_portfolio_filter($query) {
			global $wpdb;
			if(!is_archive() && !is_admin() && !is_single()){
				$category = sf_get_category_id(get_option('sf_portfolio_category'));
				if (!empty($category) && get_option('sf_portfolio_exclude')) {
					$array = array($category => $category);
					$array2 = array();
					$categories = get_categories('child_of='.$category);
					foreach($categories as $k) {
						$array2[$k->term_id] = $k->term_id;
					}
					$array2 = array_merge($array,$array2);
					$query = sf_portfolio_remove_category($query,$array2);
				}
			}
			return $query;
		}
		function sf_portfolio_remove_category($query,$category){
			$cat = $query->get('category__in');
			$cat2 = array_merge($query->get('category__not_in'),$category);
			if($cat && $cat2){
				foreach($cat2 as $k=>$c){
					if(in_array($c,$cat)){
						unset($cat2[$k]);
					}
				}
			}
			$query->set('category__not_in',$cat2);

			return $query;
		}
		add_filter('pre_get_posts', 'sf_portfolio_filter');

	/* Exclude Portfolio Category & Child Categories From Category List And Dropdown Widget */
		function sf_category_filter($args) {
			$category = sf_get_category_id(get_option('sf_portfolio_category'));
			if (!empty($category) && get_option('sf_portfolio_exclude')) {
				$myarray = array(
						'exclude'    => $category,
						'exclude_tree'    => $category,
						);
				$args = array_merge($args, $myarray);
			}
			return $args;
		}
		add_filter('widget_categories_args', 'sf_category_filter');
		add_filter('widget_categories_dropdown_args', 'sf_category_filter');

	/* Generate a list of child categories of the portfolio category for filtering on the portfolio items by category */
		function sf_list_portfolio_child_categories($topcat,$active,$pagepermalink) {
			$categories = get_categories('child_of='.$topcat);
			if (hasQuestionMark($pagepermalink)) {
				$pagepermlinkadd = $pagepermalink."&";
			}
			else {
				$pagepermlinkadd = $pagepermalink."?";
			}
			$array2 = array();
			foreach($categories as $k) {
				$array2[$k->term_id] = $k->name;
			}
			foreach ($array2 as $x => $y) {
				if ($x == $active) { $addtoclass = " class=\"active\""; }
				echo "<li".$addtoclass."><a href=\"".$pagepermlinkadd."pcat=".$x."\">".$y."</a></li>";
				unset($addtoclass);
			}
		}

	/* Go threw a string to see if it contains a certain character */
		function hasQuestionMark($string) {
			$length = strlen($string);
			for($i = 0; $i < $length; $i++) {
				$char = $string[$i];
				if($char == '?') { return true; }
			}
			return false;
		}

	/* Get the Category ID */
		function sf_get_category_id($cat_name) {
			$categories = get_categories();
			foreach($categories as $category){ //loop through categories
				if($category->name == $cat_name){
					$cat_id = $category->term_id;
					break;
				}
			}
			if (empty($cat_id)) { return 0; }
			return $cat_id;
		}

	/**
	 * Tests if any of a post's assigned categories are descendants of target categories
	 *
	 * @param int|array $cats The target categories. Integer ID or array of integer IDs
	 * @param int|object $_post The post. Omit to test the current post in the Loop or main query
	 * @return bool True if at least 1 of the post's categories is a descendant of any of the target categories
	 * @see get_term_by() You can get a category by name or slug, then pass ID to this function
	 * @uses get_term_children() Passes $cats
	 * @uses in_category() Passes $_post (can be empty)
	 * @version 2.7
	 * @link http://codex.wordpress.org/Function_Reference/in_category#Testing_if_a_post_is_in_a_descendant_category
	 */
		function post_is_in_descendant_category( $cats, $_post = null ) {
			foreach ( (array) $cats as $cat ) {
				// get_term_children() accepts integer ID only
				$descendants = get_term_children( (int) $cat, 'category');
				if ( $descendants && in_category( $descendants, $_post ) )
					return true;
			}
			return false;
		}

	/* Generate Custom Logo & Favicon */
		function sf_get_logo() {
			$default_logo = get_bloginfo('template_directory')."/images/logo.png";
			$custom_logo = get_option('sf_basic_logo');
			$logo = (empty($custom_logo)) ? $default_logo : $custom_logo;
			return $logo;
		}
		function sf_get_favicon() {
			$default_favicon = get_bloginfo('template_directory')."/images/favicon.ico";
			$custom_favicon = get_option('sf_basic_favicon');
			$favicon = (empty($custom_favicon)) ? $default_favicon : $custom_favicon;
			return $favicon;
		}

	/* Include Admin Option Panel File */
		include(TEMPLATEPATH . "/admin/index.php");

	/* RSS Custom Widget */
		function sf_rss_widget($args) {
			extract($args);
			?>
						<div class="widget widget_rssfeed">
							<ul>
								<?php if (get_option('sf_feedburner')): ?> <li class="rss"><a href="<?php echo "http://feeds2.feedburner.com/".get_option('sf_feedburner'); ?>">Subscribe to RSS Feed</a></li>
								<?php else: ?> <li class="rss"><a href="<?php bloginfo('rss2_url'); ?>">Subscribe to RSS Feed</a></li> <?php endif; ?>

								<?php if (get_option('sf_email') && get_option('sf_feedburner')) { ?><li class="email"><a href="http://feedburner.google.com/fb/a/mailverify?uri=<?php echo get_option('sf_feedburner'); ?>&amp;loc=en_US">Subscribe by Email</a></li> <?php } ?>
								<?php if (get_option('sf_twitter')) { ?><li class="twitter"><a href="<?php echo "http://twitter.com/".get_option('sf_twitter'); ?>">Follow me on Twitter</a></li> <?php } ?>
							</ul>
						</div>
			<?php
		}
		function sf_widgets() {
			register_sidebar_widget('RSS Feed Subscribe', 'sf_rss_widget');
		}
		add_action('widgets_init','sf_widgets');


if ( ! function_exists( 'twentythirteen_entry_date' ) ) :
/**
 * Prints HTML with date information for current post.
 *
 * Create your own twentythirteen_entry_date() to override in a child theme.
 *
 * @since Twenty Thirteen 1.0
 *
 * @param boolean $echo Whether to echo the date. Default true.
 * @return string
 */
function twentythirteen_entry_date( $echo = true ) {
    $format_prefix = ( has_post_format( 'chat' ) || has_post_format( 'status' ) ) ? _x( '%1$s on %2$s', '1: post format name. 2: date', 'twentythirteen' ): '%2$s';

    $date = sprintf( '<div class="date"><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a></div>',
        esc_url( get_permalink() ),
        esc_attr( sprintf( __( 'Permalink to %s', 'twentythirteen' ), the_title_attribute( 'echo=0' ) ) ),
        esc_attr( get_the_date( 'c' ) ),
        esc_html( sprintf( $format_prefix, get_post_format_string( get_post_format() ), get_the_date() ) )
    );

    if ( $echo )
        echo $date;

    return $date;
}
endif;

if ( ! function_exists( 'twentythirteen_get_first_url' ) ) :
/**
 * Return the URL for the first link in the post content or the permalink if no
 * URL is found.
 *
 * @since Twenty Thirteen 1.0
 * @return string URL
 */
function twentythirteen_get_first_url() {
    $has_url = preg_match( '/<a\s[^>]*?href=[\'"](.+?)[\'"]/is', get_the_content(), $match );
    $link    = ( $has_url ) ? $match[1] : apply_filters( 'the_permalink', get_permalink() );

    return esc_url_raw( $link );
}
endif;

if ( ! function_exists( 'twentythirteen_featured_gallery' ) ) :
/**
 * Displays first gallery from post content. Changes image size from thumbnail
 * to large, to display a larger first image.
 *
 * @since Twenty Thirteen 1.0
 *
 * @return void
 */
function twentythirteen_featured_gallery() {
    $pattern = get_shortcode_regex();

    if ( preg_match( "/$pattern/s", get_the_content(), $match ) ) {
        if ( 'gallery' == $match[2] ) {
            if ( ! strpos( $match[3], 'size' ) )
                $match[3] .= ' size="medium"';

            echo do_shortcode_tag( $match );
        }
    }
}
endif;

if ( ! function_exists( 'twentythirteen_post_nav' ) ) :
/**
 * Displays navigation to next/previous post when applicable.
*
* @since Twenty Thirteen 1.0
*
* @return void
*/
function twentythirteen_post_nav() {
    global $post;

    // Don't print empty markup if there's nowhere to navigate.
    $previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
    $next = get_adjacent_post( false, '', false );

    if ( ! $next && ! $previous )
        return;
    ?>
    <nav class="navigation post-navigation clearfix" role="navigation">
        <h1 class="assistive-text visuallyhidden"><?php _e( 'Post navigation', 'twentythirteen' ); ?></h1>
        <div class="nav-links">

            <div class="nav-previous"><?php previous_post_link( '%link', _x( '<span class="meta-nav">&larr;</span> %title', 'Previous post link', 'twentythirteen' ) ); ?></div>
            <div class="nav-next"><?php next_post_link( '%link', _x( '%title <span class="meta-nav">&rarr;</span>', 'Next post link', 'twentythirteen' ) ); ?></div>

        </div><!-- .nav-links -->
    </nav><!-- .navigation -->
    <?php
}
endif;

if ( ! function_exists( 'twentythirteen_paging_nav' ) ) :
/**
 * Displays navigation to next/previous set of posts when applicable.
 *
 * @since Twenty Thirteen 1.0
 *
 * @return void
 */
function twentythirteen_paging_nav() {
    global $wp_query;

    // Don't print empty markup if there's only one page.
    if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) )
        return;
    ?>
    <nav class="navigation paging-navigation" role="navigation">
        <h1 class="assistive-text visuallyhidden"><?php _e( 'Posts navigation', 'twentythirteen' ); ?></h1>
        <div class="nav-links">

            <?php if ( get_next_posts_link() ) : ?>
            <div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'twentythirteen' ) ); ?></div>
            <?php endif; ?>

            <?php if ( get_previous_posts_link() ) : ?>
            <div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'twentythirteen' ) ); ?></div>
            <?php endif; ?>

        </div><!-- .nav-links -->
    </nav><!-- .navigation -->
    <?php
}
endif;

if ( ! function_exists( 'twentythirteen_entry_meta' ) ) :
/**
 * Prints HTML with meta information for current post: categories, tags, permalink, author, and date.
 *
 * Create your own twentythirteen_entry_meta() to override in a child theme.
 *
 * @since Twenty Thirteen 1.0
 *
 * @return void
 */
function twentythirteen_entry_meta() {

    if ( is_sticky() && is_home() && ! is_paged() ) {
        echo '<div class="featured-post"><span>' . __( 'Featured Post', 'twentythirteen' ) . '</span></div>';
    }

    if ( ! has_post_format( 'aside' ) && ! has_post_format( 'link' ) && 'post' == get_post_type() ) {
        twentythirteen_entry_date();

            echo '<div class="comments">';
            comments_popup_link('<span class=\'comments-none\'>No comments</span>', '<span class=\'comments-1\'>1 comment</span>', '<span class=\'comments-plural\'>% comments</span>', '', '<span class=\'comments-off\'>Comments Off</span>' );
            echo '</div>';
    }

    // Post author
    if ( 'post' == get_post_type() ) {
        printf( '<div class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></div>',
            esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
            esc_attr( sprintf( __( 'View all posts by %s', 'twentythirteen' ), get_the_author() ) ),
            get_the_author()
        );
    }

    // Translators: used between list items, there is a space after the comma.
    $categories_list = get_the_category_list( __( '</span><span class="category filter"> ', 'twentythirteen' ) );

    if ( $categories_list ) {
        echo '<div class="categories-links filter-links clearfix"><i class="icon-folder-open"></i><span class="filter category">' . $categories_list . '</span></div>';
    }

    // Translators: used between list items, there is a space after the comma.
    $tag_list = get_the_tag_list( '', __( '</span><span class="tag filter">', 'twentythirteen' ) );
    if ( $tag_list ) {
        echo '<div class="tags-links filter-links clearfix"><i class="icon-tag"></i><span class="tag filter">' . $tag_list . '</span></div>';
    }


}
endif;



// Register Custom Post Type
function custom_post_type() {
	$labels = array(
		'name'                => _x( 'Projects', 'Post Type General Name', 'text_domain' ),
		'singular_name'       => _x( 'Project', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'           => __( 'Project', 'text_domain' ),
		'parent_item_colon'   => __( 'Parent Projects:', 'text_domain' ),
		'all_items'           => __( 'All Projects', 'text_domain' ),
		'view_item'           => __( 'View Project', 'text_domain' ),
		'add_new_item'        => __( 'Add New Project', 'text_domain' ),
		'add_new'             => __( 'New Project', 'text_domain' ),
		'edit_item'           => __( 'Edit Project', 'text_domain' ),
		'update_item'         => __( 'Update Project', 'text_domain' ),
		'search_items'        => __( 'Search projects', 'text_domain' ),
		'not_found'           => __( 'No projects found', 'text_domain' ),
		'not_found_in_trash'  => __( 'No projects found in Trash', 'text_domain' ),
	);

	$rewrite = array(
		'slug'                => 'project',
		'with_front'          => true,
		'pages'               => true,
		'feeds'               => true,
	);

	$args = array(
		'label'               => __( 'project', 'text_domain' ),
		'description'         => __( 'Product information pages', 'text_domain' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'trackbacks', 'revisions', 'custom-fields', 'page-attributes', 'post-formats', ),
		'taxonomies'          => array( 'category', 'post_tag' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'menu_icon'           => '',
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'query_var'           => 'project',
		'rewrite'             => $rewrite,
		'capability_type'     => 'page',
	);

	register_post_type( 'project', $args );
}

// Hook into the 'init' action
add_action( 'init', 'custom_post_type', 0 );



function register_my_menus() {
    register_nav_menus(
        array(
        'header-menu' => __( 'Header Menu' ),
        'menu-2' => __( 'Menu 2' )
        )
    );
}

add_action( 'init', 'register_my_menus' );


?>
