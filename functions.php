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

//require_once locate_template('/inc/extras.php');           // Utility functions

function spackler_setup() {
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
     * This theme styles the visual editor to rese<p></p>mble the theme style,
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

    add_filter('show_admin_bar', '__return_false');
}
add_action( 'after_setup_theme', 'spackler_setup' );


// Generates semantic classes for BODY element
function spackler_body_class( $print = true ) {
    global $wp_query, $current_user;

    // It's surely a WordPress blog, right?
    $c = array('wp');

    // Applies the time- and date-based classes (below) to BODY element
    spackler_date_classes( time(), $c );

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
            spackler_date_classes( mysql2date( 'U', $wp_query->post->post_date ), $c, 's-' );

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

/**
 * spackler_post_class Generates semantic classes for each post DIV element
 * @param  String  $classes String of optional classes to add to post
 * @param  boolean $print   whether to print classes
 * @return [type]           [description]
 */
function spackler_post_class($classes = '', $print = true) {
    global $post, $spackler_post_alt;

    // hentry for hAtom compliace, gets 'alt' for every other post DIV, describes the post type and p[n]
    $c = array( 'hentry', "p$spackler_post_alt", $post->post_type, $classes, $post->post_status );

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
    spackler_date_classes( mysql2date( 'U', $post->post_date ), $c );

    // If it's the other to the every, then add 'alt' class
    if ( ++$spackler_post_alt % 2 )
        $c[] = 'alt';

    // Separates classes with a single space, collates classes for post DIV
    $c = join( ' ', apply_filters( 'post_class', $c ) ); // Available filter: post_class

    // And tada!
    return $print ? print($c) : $c;
}


// Generates semantic classes for each comment LI element
function spackler_comment_class( $print = true ) {
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
    spackler_date_classes( mysql2date( 'U', $comment->comment_date ), $c, 'c-' );
    if ( ++$sandbox_comment_alt % 2 )
        $c[] = 'alt';

    // Separates classes with a single space, collates classes for comment LI
    $c = join( ' ', apply_filters( 'comment_class', $c ) ); // Available filter: comment_class

    // Tada again!
    return $print ? print($c) : $c;
}

// Generates time- and date-based classes for BODY, post DIVs, and comment LIs; relative to GMT (UTC)
function spackler_date_classes( $t, &$c, $p = '' ) {
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


function spackler_get_favicon() {
    $default_favicon = get_bloginfo('template_directory')."/images/favicon.ico";
    $custom_favicon = get_option('sf_basic_favicon');
    $favicon = (empty($custom_favicon)) ? $default_favicon : $custom_favicon;
    return $favicon;
}


if ( ! function_exists( 'spackler_entry_date' ) ) :
/**
 * Prints HTML with date information for current post.
 *
 * Create your own spackler_entry_date() to override in a child theme.
 *
 * @since Twenty Thirteen 1.0
 *
 * @param boolean $echo Whether to echo the date. Default true.
 * @return string
 */
function spackler_entry_date( $echo = true ) {
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

if ( ! function_exists( 'spackler_get_first_url' ) ) :
/**
 * Return the URL for the first link in the post content or the permalink if no
 * URL is found.
 *
 * @since Twenty Thirteen 1.0
 * @return string URL
 */
function spackler_get_first_url() {
    $has_url = preg_match( '/<a\s[^>]*?href=[\'"](.+?)[\'"]/is', get_the_content(), $match );
    $link    = ( $has_url ) ? $match[1] : apply_filters( 'the_permalink', get_permalink() );

    return esc_url_raw( $link );
}
endif;

if ( ! function_exists( 'spackler_featured_gallery' ) ) :
/**
 * Displays first gallery from post content. Changes image size from thumbnail
 * to large, to display a larger first image.
 *
 * @since Twenty Thirteen 1.0
 *
 * @return void
 */
function spackler_featured_gallery() {
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

if ( ! function_exists( 'spackler_post_nav' ) ) :
/**
 * Displays navigation to next/previous post when applicable.
*
* @since Twenty Thirteen 1.0
*
* @return void
*/
function spackler_post_nav() {
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

if ( ! function_exists( 'spackler_paging_nav' ) ) :
/**
 * Displays navigation to next/previous set of posts when applicable.
 *
 * @since Twenty Thirteen 1.0
 *
 * @return void
 */
function spackler_paging_nav() {
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

if ( ! function_exists( 'spackler_entry_meta' ) ) :
/**
 * Prints HTML with meta information for current post: categories, tags, permalink, author, and date.
 *
 * Create your own spackler_entry_meta() to override in a child theme.
 *
 * @since Twenty Thirteen 1.0
 *
 * @return void
 */
function spackler_entry_meta() {

    if ( is_sticky() && is_home() && ! is_paged() ) {
        echo '<div class="post__featured"><span>' . __( 'Featured Post', 'twentythirteen' ) . '</span></div>';
    }

    if ( ! has_post_format( 'aside' ) && ! has_post_format( 'link' ) && 'post' == get_post_type() ) {
        spackler_entry_date();

        echo '<div class="post__comments-count">';
        comments_popup_link('<span class=\'comments-none\'>No comments</span>', '<span class=\'comments-1\'>1 comment</span>', '<span class=\'comments-plural\'>% comments</span>', '', '<span class=\'comments-off\'>Comments Off</span>' );
        echo '</div>';
    }

    // Post author
/*    if ( 'post' == get_post_type() ) {
        printf( '<div class="post__author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></div>',
            esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
            esc_attr( sprintf( __( 'View all posts by %s', 'spackler' ), get_the_author() ) ),
            get_the_author()
        );
    }*/

    // Translators: used between list items, there is a space after the comma.
    $categories_list = get_the_category_list( __( '</span><span class="category filter"> ', 'twentythirteen' ) );

    if ( $categories_list ) {
        echo '<div class="categories-links filter-links clearfix"><span class="si-icon si-icon-small si-icon-folder"></span><span class="filter category">' . $categories_list . '</span></div>';
    }

    $tag_icon = '<span class="si-icon si-icon-small si-icon-tags"></span>';

    // Translators: used between list items, there is a space after the comma.
    $tag_list = get_the_tag_list( '', __( '</span><span class="tag filter">', 'spackler' ) );

    if ( $tag_list ) {
        echo '<div class="tags-links filter-links clearfix">' . $tag_icon . '<span class="tag filter">' . $tag_list . '</span></div>';
    }


}
endif;


function register_my_menus() {
    register_nav_menus(
        array(
        'header-menu' => __( 'Header Menu' ),
        'menu-2' => __( 'Menu 2' )
        )
    );
}

add_action( 'init', 'register_my_menus' );


function spackler_social_links() {
?>
    <div class="share">
        <h2 class="share__title">Share</h2>
        <ul class="share__btns">
            <li>
                <a class="js-social-share icon-fallback-text share__btn share__btn--facebook" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo get_permalink(); ?>&amp;t=<?php echo get_the_title(); ?>" target="_blank" title="Share on Facebook">
                  <span class="si-icon si-icon-fb si-icon-medium"></span>
                  <span class="visuallyhidden">Facebook</span>
                </a>
            </li>
            <li>
                <a class="js-social-share icon-fallback-text share__btn share__btn--twitter" href="https://twitter.com/intent/tweet?source=<?php echo get_permalink(); ?>&amp;text=<?php echo get_the_title(); ?>:<?php echo get_permalink(); ?>" target="_blank" title="Tweet">
                  <span class="si-icon si-icon-twitter-bird si-icon-medium"></span>
                  <span class="visuallyhidden">Twitter</span>
                </a>
            </li>
            <li>
                <a class="js-social-share icon-fallback-text share__btn share__btn--google" href="https://plus.google.com/share?url=<?php echo get_permalink(); ?>" target="_blank" title="Share on Google+">
                  <span class="si-icon si-icon-google si-icon-medium" aria-hidden="true"></span>
                  <span class="visuallyhidden">Google+</span>
                </a>
            </li>
        </ul>
      </div>
<?php
}


require_once('inc/project-type.php');       // cutom post type for projects
require_once('inc/extras.php');             // Utility functions

