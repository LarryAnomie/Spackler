<?php

    if ($_SERVER['SERVER_NAME'] == 'lawrencenaman.dev') {
        $environment = 'local';
    } else {
        $environment = 'production';
    }

    $page = $_SERVER['REQUEST_URI'];
    $arr = explode('/', $page);
    $page = '';
    //this handles local host and live urls
    if ($arr[1] == 'wordpress') {
        //on local host
        if (!$arr[2]){
            $page = 'home';
        } else {
            $page = $arr[3];
        }
    } else {
        //live website
        if (!$arr[1]){
            $page = 'home';
        } else {
            $page = $arr[1];
        }
    };

    // for dev
    //$environment = 'production';
?>
<!doctype html>
<!--[if lt IE 7 ]> <html lang="en" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html lang="en" class="no-js"><!--<![endif]-->
  <head>
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
    <meta name="google-site-verification" content="QjLb5BVJzywh68UDIbgVppQZq9KQrfYm6Cor406Fn2I" />
	<meta name="google-site-verification" content="xFKRzlluQpYjxbkcbZL0KWW8ajk2ZUL2S2IyNuevhkI" />
    <meta property="fb:admins" content="581636915" />
    <meta name="author" content="Lawrence Naman">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <!--"We're doing all we can. but I'm not Jesus Christ. I've come to accept that now."-->
    <title>
	<?php if ( is_front_page() ) { bloginfo('name'); } ?>
    <?php if ( is_home() ) {  echo "Blog | ";  bloginfo('name'); } ?>
    <?php if ( is_search() ) { ?><?php bloginfo('name'); ?>&nbsp;|&nbsp;Search Results<?php } ?>
    <?php if ( is_author() ) { ?><?php bloginfo('name'); ?>&nbsp;|&nbsp;Author Archives<?php } ?>
    <?php if ( is_single() ) { ?><?php wp_title(''); ?>&nbsp;|&nbsp;<?php //bloginfo('name'); ?><?php } ?>
    <?php if ( is_page() && !is_front_page() ) { ?><?php bloginfo('name'); ?>&nbsp;|&nbsp;<?php wp_title(''); ?><?php } ?>
    <?php if ( is_category() ) { ?><?php bloginfo('name'); ?>&nbsp;|&nbsp;Archive&nbsp;|&nbsp;<?php single_cat_title(); ?><?php } ?>
    <?php if ( is_month() ) { ?><?php bloginfo('name'); ?>&nbsp;|&nbsp;Archive&nbsp;|&nbsp;<?php the_time('F'); ?><?php } ?>
    <?php if ( is_404() ) { ?><?php bloginfo('name'); ?>&nbsp;|&nbsp;Couldn't find what your looking for<?php } ?>
    <?php if (function_exists('is_tag')) { if ( is_tag() ) { ?><?php bloginfo('name'); ?>&nbsp;|&nbsp;Tag Archive&nbsp;|&nbsp;<?php  single_tag_title("", true); } } ?>
    </title>
    <link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
    <link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo('rss_url'); ?>" />
    <link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo('atom_url'); ?>" />
    <link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Comments Feed" href="<?php bloginfo('comments_rss2_url'); ?>" />
    <link rel="shortcut icon" href="<?php echo spackler_get_favicon(); ?>" title="Favicon" />

    <?php if ($environment == 'local') : ?>
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/assets/app/css/style.css?v=1.1.2" type="text/css" media="screen" />
        <script src="<?php bloginfo('template_url'); ?>/assets/app/scripts/vendor/modernizr.js?v=1.0.0"></script>
    <?php else : ?>
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/assets/dist/css/style.css?v=1.0.2" type="text/css" media="screen" />
        <script src="<?php bloginfo('template_url'); ?>/assets/dist/scripts/vendor/modernizr.js?v=1.0.0"></script>
    <?php endif; ?>

    <link href='https://fonts.googleapis.com/css?family=Oswald:400,700,300' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic' rel='stylesheet' type='text/css'>

    <!--[if lte IE 6]>
        <link rel="stylesheet" href="http://universal-8b8e.ie6.css.googlecode.com/files/ie6.1.1.css" media="screen, projection">
    <![endif]-->
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    <?php wp_head(); ?>
	<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>

    </head>

    <body id="<?php echo $page;?>" class="<?php spackler_body_class() ?>">
        <div id="wrapper" class="container">
            <header class="header visible" id="header">
                <div class="row">
                    <?php if ( is_front_page() ) { echo "<h1 id='logo' class='logo'>";} else {echo "<p id='logo' class='clearfix logo'>";} ?><a class="home-link" href="<?php bloginfo('home'); ?>">Lawrence Naman</a><?php if ( is_front_page() ) { echo "</h1>";} else {echo "</p>"; }  ?>

                    <p class="nav-opener js-nav-opener">
                        <a class="nav-opener__link" href="#access"><span class="nav-opener__text">Menu</span><span class="si-icon si-icon-hamburger-cross nav-opener__icon" data-icon-name="hamburgerCross"></span></a>
                    </p>
                </div>
            </header>

            <div class="nav-overlay js-nav-overlay" id="nav-overlay">
                <div class="absolute-center">
                    <nav id="access" class="main-navigation" role="navigation">
                        <?php wp_nav_menu( array( 'menu_id' => 'nav','container' => false, 'theme_location' => 'header-menu', 'menu_class' => 'nav-menu', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
                    </nav><!-- #site-navigation -->
                    <p>Say Hello...</p>
                    <div class="social columns small-centered large-centered large-6 small-12">
                        <a class="si-icon-twitter svg-icon-link" title="Twitter" href="https://twitter.com/LarryNaman">
                            <span class="visuallyhidden">Twitter</span>
                        </a>
                        <a class="si-icon-git-hub svg-icon-link" title="GitHub" href="https://github.com/LarryAnomie">
                            <span class="visuallyhidden">GitHub</span>
                        </a>
                        <a class="si-icon-instagram svg-icon-link" title="Instagram" href="http://instagram.com/larrynaman">
                            <span class="visuallyhidden">Instagram</span>
                        </a>
                        <a class="si-icon-li svg-icon-link" title="LinkedIn" href="https://www.linkedin.com/in/larrynaman10101">
                            <span class="visuallyhidden">LinkedIn</span>
                        </a>
                    </div>
                </div>
            </div>

            <section id="content" role="main" class="row">
