	<aside class="sidebar columns three">
        <div class="widget widget_pages">
        	<h3 id="twit">Latest Tweets</h3>
            <div id="tweet"></div>
        </div>
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar Widget') ) : ?>
		<?php endif; ?>
	</aside>

