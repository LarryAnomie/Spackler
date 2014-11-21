<div class="project">
    <h1 class="title columns twelve"><?php the_title(); ?></h1>
    <div class="project-text columns five">
        <?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>
        <?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
    </div>
    <div class="project-media columns seven">

        <!--slider here-->
        <?php 
            $thumb1 = get_post_meta($post->ID, 'project-1', true); 
            $thumb2 = get_post_meta($post->ID, 'project-2', true); 
            $thumb3 = get_post_meta($post->ID, 'project-3', true); 

            if($thumb1 != '') {
        ?>
        <div id="slider" class="flexslider">
            <ul class="slides">
                <li><img src="<?php echo $thumb1; ?>" alt="<?php the_title(); ?>" /></li>

                <?php 
                    }
                    if($thumb2 != '') {
                ?>

                <li><img src="<?php echo $thumb2; ?>" alt="<?php the_title(); ?>" /></li>

                <?php 
                    }
                    if($thumb3 != '') {
                ?>
                <li><img src="<?php echo $thumb3; ?>" alt="<?php the_title(); ?>" /></li>

                <?php 
                    }
                ?>
            </ul><!--.slides-->
        </div><!--.flexSlider-->
    </div><!--.project-media-->
</div><!--.project-->
