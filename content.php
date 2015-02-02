<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 */

$post_modifier = '';

if (!is_single()) {
    $post_modifier = 'post--list-view';
}

?>

<article id="post-<?php the_ID(); ?>" class="<?php spackler_post_class($post_modifier, true); ?>" >
    <header class="post__header">
        <?php if ( has_post_thumbnail() && ! is_single() && ! post_password_required() ) : ?>
        <div class="post__thumbnail">
            <?php the_post_thumbnail(); ?>
        </div>
        <?php endif; ?>

        <?php if ( is_single() ) : ?>
        <h1 class="post__title"><?php the_title(); ?></h1>
        <?php else : ?>
        <h1 class="post__title">
            <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'spackler' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
        </h1>
        <?php endif; // is_single() ?>

        <div class="post__meta">
            <?php spackler_entry_meta(); ?>
            <?php //edit_post_link( __( 'Edit', 'spackler' ), '<span class="edit-link">', '</span>' ); ?>
        </div><!-- .post__meta -->
    </header><!-- .post__header -->

    <?php if ( is_search() ) : // Only display Excerpts for Search ?>
    <div class="post__summary">
        <?php the_excerpt(); ?>
    </div><!-- .post__summary -->
    <?php else : ?>
    <div class="post__content">
        <?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'spackler' ) ); ?>
        <?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'spackler' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
    </div><!-- .post__content -->
    <?php endif; ?>

    <footer class="post__footer">
        <?php if ( is_single() && get_the_author_meta( 'description' ) && is_multi_author() ) : ?>
            <?php get_template_part( 'author-bio' ); ?>
        <?php endif; ?>
        <?php if ( is_single() ) : ?>
            <?php spackler_social_links(); ?>
        <?php endif; ?>
    </footer><!-- .post__meta -->
</article><!-- #post -->
