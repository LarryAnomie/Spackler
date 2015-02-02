            </section><!--#content-->
        </div><!--#wrapper-->
        <footer id="footer" class="container footer">
            <div id="footer-content" class="footer__content">
                <div class="row">
                    <h2 class="hidden">Footer</h2>
                </div><!--.row-->
                <div id="end" class="row">
                    <div class="social columns small-centered large-centered large-6 small-12">
                        <a class="social__link si-icon-twitter svg-icon-link" title="Twitter" href="https://twitter.com/LarryNaman">
                            <span class="visuallyhidden">Twitter</span>
                        </a>
                        <a class="social__link si-icon-git-hub svg-icon-link" title="GitHub" href="https://github.com/LarryAnomie">
                            <span class="visuallyhidden">GitHub</span>
                        </a>
                        <a class="social__link si-icon-instagram svg-icon-link" title="Instagram" href="http://instagram.com/larrynaman">
                            <span class="visuallyhidden">Instagram</span>
                        </a>
                        <a class="social__link si-icon-li svg-icon-link" title="LinkedIn" href="https://www.linkedin.com/in/larrynaman10101">
                            <span class="visuallyhidden">LinkedIn</span>
                        </a>
                    </div>
                    <p id="copyright" class="copyright columns small-centered large-centered large-8 small-12">&copy; 2008 - 2015 Lawrence Naman. All rights reserved.</p>
                </div><!--#end-->
            </div><!--#footer-content-->
        </footer><!--footer-->

    <?php // Checking if the wp-local-config.php file exists ?>
    <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] .'/wp-local-config.php')) : ?>
        <script src="<?php bloginfo('template_url'); ?>/assets/app/scripts/require.js" data-main="<?php bloginfo('template_url'); ?>/assets/app/scripts/main.js"></script>
    <?php else : ?>
        <script src="<?php bloginfo('template_url'); ?>/assets/dist/scripts/main.js?v=1.0.0"></script>
    <?php endif; ?>

        <!--analytics -->
        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

            ga('create', 'UA-5598802-2', 'auto');
            ga('send', 'pageview');
        </script>
        <?php wp_footer(); ?>
    </body>
</html>
