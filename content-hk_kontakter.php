<?php
/**
 * The default template for displaying content
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
global $default_settings;
?>
	<article id="post-<?php the_ID(); ?>" <?php post_class((is_sticky())?"sticky  post":"post"); ?>>
		<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'twentyeleven' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
		<div class="article-border-wrapper">
		<div class="article-wrapper">
			<div class="content-wrapper">

				<div class="summary-content"></div><div>
					<?php hk_the_contact(array(
						'image' => true,
						'name' => false,
						'title' => true,
						'workplace' => true,
						'phone' => true,
						'email' => true,
						'description' => true,
						'address' => true,
						'visit_hours' => true,
						'map' => true,
						'title_link' => false)); ?>
				</div><!-- .summary-content -->

			</div><!-- .content-wrapper -->
		</div>
		</div>
		<span class='hidden contact_id'><?php the_ID(); ?></span>
	</article><!-- #post-<?php the_ID(); ?> -->
