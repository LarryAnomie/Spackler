<?php
/*
Template Name: Blog Home
*/
?>
            <?php get_header(); ?>

                <div class="main-content columns nine">
                    <h1>Blog</h1>
                <?php if (have_posts()) : ?>
                    <?php /* Start the Loop */ ?>
                    <?php while ( have_posts() ) : the_post(); ?>
                        <?php get_template_part( 'content', get_post_format() ); ?>
                    <?php endwhile; ?>
                    
                    <?php 
                    if(function_exists('wp_pagenavi')):
                        wp_pagenavi();
                    else:
                    ?>
                    <div class="navigation">
                        <div class="alignleft"><?php next_posts_link('&laquo; Older Entries') ?></div>
                        <div class="alignright"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
                    </div>
                    <?php endif; ?>
                    
                <?php else : ?>
                    <?php include_once(TEMPLATEPATH."/page-error.php"); ?>
                <?php endif; ?>
                
                </div>
                
            <?php get_sidebar(); ?>
            <?php get_footer(); ?>
