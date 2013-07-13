            <?php get_header(); ?>

                <div class="main-content columns nine">
                    
                <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>
                    <article class="blogpost row">
                        <div class="post-meta columns two">
                            <div class="date">
                                <span class="month"><?php the_time('F') ?></span>
                                <span class="day"><?php the_time('j') ?></span>
                                <span class="year"><?php the_time('Y') ?></span>
                            </div>
                            <div class="comments">
                                <?php comments_popup_link('<span class=\'no\'>No </span><span>comments</span>', '<span class=\'no\'>1 </span><span>comments</span>', '<span class=\'no\'>% </span><span>comments</span>'); ?>
                            </div>
                        </div>
                        <div class="post-content columns ten">
                            <h2 class="title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
                            <div class="meta">Posted <?php //the_time('F jS, Y') ?> in <?php the_category(', ') ?> by <?php the_author() ?></div>
                            <div class="entry">
                                <?php the_content('Continue Reading &raquo;'); ?>
                            </div>
                        </div>
                    </article>
                    
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
