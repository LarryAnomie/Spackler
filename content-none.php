<?php
/**
 * The template for displaying a "No posts found" message.
 *
 */
?>
<div class="page page-404">
    <header class="page__header">
        <h1 class="page__title"><?php _e( 'Nothing Found', 'spackler' ); ?></h1>
    </header><!-- .page__header -->

    <div class="page__content">
        <?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

        <p><?php printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'spackler' ), admin_url( 'post-new.php' ) ); ?></p>

        <?php elseif ( is_search() ) : ?>

        <p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with different keywords.', 'spackler' ); ?></p>
        <?php get_search_form(); ?>

        <?php else : ?>

        <p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'spackler' ); ?></p>
        <?php get_search_form(); ?>

        <?php endif; ?>
    </div><!-- /.page__content -->
</div><!-- /.page -->
