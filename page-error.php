<div class="main-content columns eight">
	<div class="blogpost">
		<div class="entry">
		<?php  if (is_category()): ?>
				<h3>The Category is empty</h3>
					<p>
						Im sorry to say that no articles have been written for this category yet. 
					</p>
		<?php elseif (is_search()): ?>
				<h3>Search Results</h3>
					<p>Your search - <strong><?PHP echo $_GET[s]; ?></strong> - did not match any documents. </p>
					Suggestions:
					<ul>
						<li>Make sure all words are spelled correctly.</li>
						<li>Try different keywords.</li>
						<li>Try more general keywords.</li>
						<li>Try fewer keywords.</li>
					</ul>
		<?php  else: ?>
            <div id="four-oh-four">
				<h1>4-d'oh-4</h1>
					<p>The page you've requested can not be displayed. It appears you've missed your intended destination, either through a bad or outdated link, or a typo in the page you were hoping to reach.</p>
              </div>
		<?php endif; ?>
		</div><!--.entry-->
	</div><!--.blog-post-->
</div><!--.main-cotent-->