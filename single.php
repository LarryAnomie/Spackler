<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */

get_header(); ?>

    <div id="primary" class="content-area">
        <div class="main-content columns small-12 large-10 large-centered">

            <?php /* The loop */ ?>
            <?php while ( have_posts() ) : the_post(); ?>
            <?php
                $category = sf_get_category_id(get_option('sf_portfolio_category'));
                if (in_category($category) || post_is_in_descendant_category($category)) { include(TEMPLATEPATH . "/template-portfolioitem.php"); $footer = "no";
                } else {
            ?>

                <?php get_template_part( 'content', get_post_format() ); ?>
                <?php twentythirteen_post_nav(); ?>
                <?php comments_template(); ?>
            <?php } //end else ?>
            <?php endwhile; ?>

        </div><!-- #content -->
    </div><!-- #primary -->

<?php //get_sidebar(); ?>
<?php get_footer(); ?>
