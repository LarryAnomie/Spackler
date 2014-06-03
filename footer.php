            </section><!--#content-->
        </div><!--#wrapper-->
        <footer id="footer" class="container">
            <div id="footer-content">
                <div class="row">
                    <h2 class="hidden">Footer</h2>
                    <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Home Widget') ) : ?>
                    <?php endif; ?>
                </div><!--.row-->
                <div id="end" class="row">
                    <p id="copyright" class="columns large-12 small-12">&copy; 2008 - 2014 Lawrence Naman. All rights reserved.</p>
                </div><!--#end-->
            </div><!--#footer-content-->
        </footer><!--footer-->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="assets/js/libs/jquery.js"><\/script>')</script>
        <script src="<?php bloginfo('template_url'); ?>/assets/js/libs/underscore.js?301"></script>
        <script src="<?php bloginfo('template_url'); ?>/assets/js/svgicons-config.js?301"></script>
        <script src="<?php bloginfo('template_url'); ?>/assets/js/svgicons.js?301"></script>
        <script src="<?php bloginfo('template_url'); ?>/assets/js/script.js?301"></script>
        <script src="//localhost:35729/livereload.js"></script>

        <!--analytics -->
        <script>
            var switchTo5x=true,
                __st_loadLate=true; //if __st_loadLate is defined then the widget will not load on domconte

            //analytics
            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-5598802-2']);
            _gaq.push(['_trackPageview']);

            (function() {
                var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
            })();

        </script>
        <?php wp_footer(); ?>
    </body>
</html>
