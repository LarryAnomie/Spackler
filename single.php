<?php get_header(); ?>
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <?php 
                        $category = sf_get_category_id(get_option('sf_portfolio_category'));
                        if (in_category($category) || post_is_in_descendant_category($category)) { include(TEMPLATEPATH . "/template-portfolioitem.php"); $footer = "no"; }
                        else {
                    ?>
                    <div class="main-content columns nine">

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
<?php if ($footer != "no") { get_sidebar();  } ?>
<?php get_footer(); ?>
