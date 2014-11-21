<?php
/*
Template Name: Projects
*/
?>
<?php get_header(); ?>

<?php $loop = new WP_Query(array('post_type' => 'project', 'posts_per_page' => -1));
  $count =0;
?>
<div class="portfolio">
    <h1 class="visuallyhidden">Projects</h1>
<?php if($loop) { ?>
    <ul id="folio">
        <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>

        <li class="project-wrapper item-<?php the_ID() ?>">
            <div class="project">
                <div class="front">
                    <?php
                        if(has_post_thumbnail()){
                            the_post_thumbnail('thumbnail');
                        }
                    ?>
                </div>
                <div class="overlay back">
                    <h2 class="project-title"><a href="<?php the_permalink(); ?>"><?php the_title() ?></a></h2>
                    <p class="project-description"><?php the_content_limit($limit_text, ''); ?></p>
                </div>
            </div>
        </li>
        <?php endwhile; ?>
    </ul>
<?php } ?>
<?php wp_reset_query(); ?>
</div><!--end .portfolio-->
<?php get_footer(); ?>
