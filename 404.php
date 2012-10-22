<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */

get_header(); ?>
	<div id="primary">
		<div id="content" role="main">

			<article id="post-0" class="post error404 not-found">
			<div class="content-wrapper">
			<div class="summary-content">
				<div class="entry-wrapper">
					<h1 class="entry-title">H&auml;r finns ingenting</h1>
					<div class="entry-content">
						<p>Anv&aumlnd s&ouml;krutan f&ouml;r att hitta.</p>
						<p>Eller v&auml;lj bland de mest bes&ouml;kta sidorna. </p>
						<?php if(function_exists('get_most_viewed')) { get_most_viewed('post'); } ?>
						
					</div>
				</div>
			</div><!-- .summary-content -->
			</div>
			</article><!-- #post-0 -->

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>