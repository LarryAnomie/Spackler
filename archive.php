<?php
/**
 * The template for displaying Archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each specific one. For example, Twenty Thirteen
 * already has tag.php for Tag archives, category.php for Category archives,
 * and author.php for Author archives.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */

get_header(); ?>

    <?php if ( have_posts() ) : ?>
        <header class="archive-header">
            <h1>Archive</h1>
        </header><!-- .archive-header -->
        <ul id="folio">
        <?php /* The loop */ ?>
        <?php while ( have_posts() ) : the_post(); ?>
            <?php //get_template_part( 'content', get_post_format() ); ?>

            <li class="project-wrapper item-<?php the_ID() ?>">
                <div class="project">
                    <div class="front">
                        <?php
                            if(has_post_thumbnail()){
                                the_post_thumbnail('thumbnail');
                            }
                        ?>
                    </div>
                    <div class="overlay back">
                        <h2 class="project-title"><a href="<?php the_permalink(); ?>"><?php the_title() ?></a></h2>
                        <p class="project-description"><?php the_content_limit($limit_text, ''); ?></p>
                    </div>
                </div>
            </li>
        <?php endwhile; ?>
        </ul>
        <?php twentythirteen_paging_nav(); ?>

    <?php else : ?>
        <?php get_template_part( 'content', 'none' ); ?>
    <?php endif; ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
