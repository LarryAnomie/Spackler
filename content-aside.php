<?php
/**
 * The template for displaying posts in the Aside post format.
 */

$post_modifier = '';

if (!is_single()) {
    $post_modifier = 'post--list-view';
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class("post-nonstandard"); ?>>
	<div class="post__content">
		<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'spackler' ) ); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'spackler' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
	</div><!-- .post__content -->

	<?php if ( is_single() ) : ?>
	<footer class="post__meta">
		<?php spackler_entry_meta(); ?>

		<?php if ( get_the_author_meta( 'description' ) && is_multi_author() ) : ?>
			<?php get_template_part( 'author-bio' ); ?>
		<?php endif; ?>
	</footer><!-- .post__meta -->

	<?php else : ?>
		<?php //edit_post_link( __( 'Edit', 'spackler' ), '<footer class="post__meta"><span class="edit-link">', '</span></footer><!-- .post__meta -->' ); ?>
	<?php endif; // is_single() ?>
</article><!-- #post -->
