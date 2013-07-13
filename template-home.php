<?php
/*
Template Name: Home
*/
?>

<?php get_header(); ?>
    <h2 id="latest-projects" class="hidden"><span>Latest Projects</span></h2>
        <div id="slider" class="flexslider">
            <ul class="slides">
                <li>
                    <a href="http://lawrencenaman.com/portfolio/jamie-shavdia/">
                      <img src="http://lawrencenaman.com/wp-content/uploads/2010/12/carousel-pic.png" alt="Responsive WordPress theme" title="Responsive WordPress theme" />
                    </a>
                </li>
                <li>
                    <a href="http://lawrencenaman.com/portfolio/brat-and-suzie/">
                      <img src="http://lawrencenaman.com/wp-content/uploads/2010/12/bsLarge.jpg" alt="Brat and Suzie" title=" Brat &amp; Suzie is an independent East London clothing company..."/>
                    </a>
                </li>
            </ul>
        </div>
    <?php if (get_option('sf_slogan_status')) { ?>
<div class="slogan columns twelve">
    <h2>Web Designer and Front-end Developer</h2>
    <p>Whereas some designers stop at Photoshop and some developers can only code, I can take your website from an initial idea through design, user testing, build to go live.
    </p>
    <ul class="block-grid mobile three-up">
        <li><i class="icon-ok-sign"></i>HTML 5, CSS/Sass, JavaScript, PHP development</li>
        <li><i class="icon-ok-sign"></i>Web, brand/identity, logo design</li>
        <li><i class="icon-ok-sign"></i>E-commerce applications: Magento, OsCommerce</li>
        <li><i class="icon-ok-sign"></i>Wordpress customisation</li>
        <li><i class="icon-ok-sign"></i>Usability evaluation</li>
        <li><i class="icon-ok-sign"></i>Accessibility recommendations</li>
    </ul>
</div>
    <?php } ?>
<?php get_footer(); ?>
