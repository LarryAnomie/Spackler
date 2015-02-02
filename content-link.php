<?php
/**
 * The template for displaying posts in the Link post format.
 */

$post_modifier = '';

if (!is_single()) {
    $post_modifier = 'post--list-view';
}

?>

<article id="post-<?php the_ID(); ?>" class="<?php spackler_post_class($post_modifier, true); ?>">
	<header class="pots__header">
		<h1 class="pots__title">
			<a href="<?php echo esc_url( spackler_get_first_url() ); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
		</h1>

		<div class="pots__meta">
			<?php spackler_entry_date(); ?>
			<?php //edit_post_link( __( 'Edit', 'spackler' ), '<span class="edit-link">', '</span>' ); ?>
		</div><!-- .pots__meta -->
	</header><!-- .pots__header -->

	<div class="post__content">
		<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'spackler' ) ); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'spackler' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
	</div><!-- .post__content -->

	<?php if ( is_single() ) : ?>
	<footer class="pots__meta">
		<?php spackler_entry_meta(); ?>
		<?php if ( get_the_author_meta( 'description' ) && is_multi_author() ) : ?>
			<?php get_template_part( 'author-bio' ); ?>
		<?php endif; ?>
	</footer>
	<?php endif; // is_single() ?>
</article><!-- #post -->
