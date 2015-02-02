<?php
/**
 * The template for displaying posts in the Status post format.
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" class="<?php spackler_post_class($post_modifier, true); ?>">
	<div class="post__content">
		<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'spackler' ) ); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'spackler' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
	</div><!-- .post__content -->

	<footer class="post__meta">
		<?php if ( is_single() ) : ?>
			<?php spackler_entry_meta(); ?>
		<?php else : ?>
			<?php spackler_entry_date(); ?>
		<?php endif; ?>
		<?php //edit_post_link( __( 'Edit', 'spackler' ), '<span class="edit-link">', '</span>' ); ?>

		<?php if ( is_single() && get_the_author_meta( 'description' ) && is_multi_author() ) : ?>
			<?php get_template_part( 'author-bio' ); ?>
		<?php endif; ?>
	</footer><!-- .post__meta -->
</article><!-- #post -->
