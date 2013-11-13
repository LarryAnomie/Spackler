<?php get_header(); ?>

<div class="main-content columns small-12 large-10 large-centered">

    <?php if ( have_posts() ) : ?>

        <?php /* The loop */ ?>
        <?php while ( have_posts() ) : the_post(); ?>
            <?php get_template_part( 'content', get_post_format() ); ?>
        <?php endwhile; ?>

        <?php twentythirteen_paging_nav(); ?>

    <?php else : ?>
        <?php get_template_part( 'content', 'none' ); ?>
    <?php endif; ?>

</div><!-- .main-content-->

<?php //get_sidebar(); ?>
<?php get_footer(); ?>
