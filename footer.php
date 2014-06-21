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

                    <div class="social columns small-centered large-centered large-6 small-12">
                        <a class="si-icon-twitter svg-icon-link" href="https://twitter.com/LarryNaman">
                            <span class="visuallyhidden">Twitter</span>
                        </a>
                        <a class="si-icon-git-hub svg-icon-link" href="https://github.com/LarryAnomie">
                            <span class="visuallyhidden">GitHub</span>
                        </a>
                        <a class="si-icon-instagram svg-icon-link" href="http://instagram.com/larrynaman">
                            <span class="visuallyhidden">Instagram</span>
                        </a>
                        <a class="si-icon-li svg-icon-link" href="https://www.linkedin.com/in/larrynaman10101">
                            <span class="visuallyhidden">Instagram</span>
                        </a>
                    </div>
                     <p id="copyright" class="copyright columns small-centered large-centered large-8 small-12">&copy; 2008 - 2014 Lawrence Naman. All rights reserved.</p>
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
