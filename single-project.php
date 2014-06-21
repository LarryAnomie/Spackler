<?php
/**
 * The Template for displaying projects
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */

get_header(); ?>

    <div id="primary" class="content-area">
        <div class="main-content columns small-12 large-10 large-centered">
            <!--project template -->
            <?php /* The loop */ ?>
            <?php while ( have_posts() ) : the_post(); ?>

                <article id="post-<?php the_ID(); ?>" class="project single-project">
                    <header class="entry-header">
                        <?php if ( has_post_thumbnail() && ! is_single() && ! post_password_required() ) : ?>
                        <div class="entry-thumbnail">
                            <?php the_post_thumbnail(); ?>
                        </div>
                        <?php endif; ?>

                        <?php if ( is_single() ) : ?>
                        <h1 class="entry-title"><?php the_title(); ?></h1>
                        <?php else : ?>
                        <h1 class="entry-title">
                            <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'twentythirteen' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
                        </h1>
                        <?php endif; // is_single() ?>

                        <div class="entry-meta">
                            <?php twentythirteen_entry_meta(); ?>
                            <?php edit_post_link( __( 'Edit', 'twentythirteen' ), '<span class="edit-link">', '</span>' ); ?>
                        </div><!-- .entry-meta -->
                    </header><!-- .entry-header -->

                    <?php if ( is_search() ) : // Only display Excerpts for Search ?>
                    <div class="entry-summary">
                        <?php the_excerpt(); ?>
                    </div><!-- .entry-summary -->
                    <?php else : ?>
                    <div class="entry-content">
                        <?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'twentythirteen' ) ); ?>
                        <?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentythirteen' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
                    </div><!-- .entry-content -->
                    <?php endif; ?>

                    <footer class="entry-meta">
                  <!--       <?php //if ( comments_open() ) : ?>
                            <div class="comments-link">
                                <?php //comments_popup_link( '<span class="leave-reply">' . __( 'Leave a comment', 'twentythirteen' ) . '</span>', __( 'One comment so far', 'twentythirteen' ), __( 'View all % comments', 'twentythirteen' ) ); ?>
                            </div>
                        <?php // endif; // comments_open() ?> -->

                        <?php if ( is_single() && get_the_author_meta( 'description' ) && is_multi_author() ) : ?>
                            <?php get_template_part( 'author-bio' ); ?>
                        <?php endif; ?>
                    </footer><!-- .entry-meta -->
                </article><!-- #post -->

            <?php endwhile; ?>

        </div><!-- .main-content -->
    </div><!-- #primary -->

<?php //get_sidebar(); ?>
<?php get_footer(); ?>
