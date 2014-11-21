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
                     <p id="copyright" class="copyright columns small-centered large-centered large-8 small-12">&copy; 2008 - 2014 Lawrence Naman. All rights reserved.</p>
                </div><!--#end-->
            </div><!--#footer-content-->
        </footer><!--footer-->



        <?php
            // Checking if the wp-local-config.php file exists
            $localConfig = $_SERVER['DOCUMENT_ROOT'] .'/wp-local-config.php';
            if (file_exists($localConfig)) {
              // Load dev styles
              // load dev js
        ?>
                <script src="<?php bloginfo('template_url'); ?>/assets/app/scripts/require.js" data-main="<?php bloginfo('template_url'); ?>/assets/app/scripts/main.js"></script>

        <?php
            }
            else {
              // Load Prod CSS
              // Load Prod JS

        ?>
                <script src="<?php bloginfo('template_url'); ?>/assets/dist/scripts/main.js"></script>

        <?php
            }
        ?>
        <!--analytics -->
        <script>

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
