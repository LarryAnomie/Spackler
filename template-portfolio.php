<?php
/*
Template Name: Portfolio
*/
?>
<?php get_header(); ?>

    <div class="portfolio">

        <h1 class="h1">Portfolio</h1>
        <?php
            $category = sf_get_category_id(get_option('sf_portfolio_category'));
            $categories = get_categories('child_of='.$category);
            $ppp = (get_option('sf_portfolio_pagination')) ? get_option('sf_portfolio_pagination') : 12;

            if (get_option('sf_portfolio_nav')) {
                if (!empty($categories)) {
                    if (isset($_GET[pcat])) {
                        $pcat = $_GET[pcat];
                    } else {
                        $addtoclass = " class=\"active\"";
                    }
        ?>

        <div class="portfnav">
            <ul>
                <li <?php echo $addtoclass; ?>><a href="<?php echo get_permalink(); ?>">All</a></li>
                <?php sf_list_portfolio_child_categories($category,$pcat,get_permalink()); ?>
            </ul>
        </div>

        <?php
                }
            }
        ?>
        <ul id="folio" class="projects-list">
        <?php
            $category = ($pcat) ? $pcat : $category;
            $temp = $wp_query;
            $wp_query= null;
            $wp_query = new WP_Query();
            $wp_query->query('showposts='.$ppp.'&cat='.$category.'&paged='.$paged);
            $limit_text = (get_option('sf_portfolio_limittext')) ? get_option('sf_portfolio_limittext') : 200;
            $counter = 0;
            while ($wp_query->have_posts()) : $wp_query->the_post();

                $do_not_duplicate = $post->ID;
                $thumb = get_post_meta($post->ID, 'thumb-small', true);
                $post_categories = wp_get_post_categories( $post->ID );
                if (empty($thumb)) { continue; }
                else { ?>
                <?php
                    foreach($post_categories as $c){
                        $cat = get_category( $c );
                        //$cats[] = array( 'name' => $cat->name, 'slug' => $cat->slug );
                        if ($cat->name != "Portfolio") {
                            $projectClass = " ".str_replace(' / ', ' ', strtolower($cat->name));
                        }
                        if ($odd = $counter%2) {
                            $projectClass .= ' odd';
                        }
                    }
                ?>
                <li class="project-wrapper">
                    <div class="project<?php echo $projectClass;?>">
                        <div class="front" href="<?php the_permalink(); ?>">
                            <img src="<?php echo $thumb; ?>" alt="<?php the_title() ?>" />
                        </div>
                        <div class="overlay back">
                            <h2 class="project-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title() ?></a>
                            </h2>
                            <p class="project-description"><?php the_content_limit($limit_text, ''); ?></p>
                        </div>
                    </div>
                </li>
                <?php $counter = $counter + 1; ?>
                <?php }
            endwhile;
        ?>
        </div>

        <?php
            if (function_exists('wp_pagenavi')) {
                wp_pagenavi();
            } else {
        ?>
            <div class="navigation">
                <div class="alignleft"><?php next_posts_link('&laquo; Older Entries') ?></div>
                <div class="alignright"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
            </div>

        <?php } ?>

        <?php $wp_query = null; $wp_query = $temp;?>
    </div>

<?php get_footer(); ?>
