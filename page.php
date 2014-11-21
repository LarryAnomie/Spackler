<?php get_header(); ?>
    <div class="main-content columns small-12 large-10 large-centered">

    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <h1 class="title"><?php the_title(); ?></h1>
        <?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>
        <?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
    <?php endwhile; endif; ?>
    <?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>
    </div>
<?php //get_sidebar(); ?>
<?php get_footer(); ?>
