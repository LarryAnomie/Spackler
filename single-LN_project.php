<?php get_header(); ?>
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <div class="main-content columns nine">
                    <article class="project row">
                        <div class="post-content columns ten">
                            <h1 class="title"><?php the_title(); ?></h1>
                            <div class="meta">Posted <?php //the_time('F jS, Y') ?> in <?php the_category(', ') ?> by <?php the_author() ?></div>
                            <div class="entry">
                                <?php the_content('<p class="serif">Read the rest of this entry &raquo;</p>'); ?>
                                <?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
                            </div>
                            <div id="social-buttons">
                                <span class='st_twitter_hcount' displayText='Tweet'></span>
                                <span class='st_fblike_hcount'></span>
                                <span class='st_plusone_hcount'></span>
                            </div>
                        </article><!--end .blogpost-->
                        
                    <?php comments_template(); ?>

                    <?php } ?>
                    </div><!--end .main-content-->
                    <?php endwhile; else: ?>
                            <?php include_once(TEMPLATEPATH."/page-error.php"); ?>
                    <?php endif; ?>
<?php get_footer(); ?>
