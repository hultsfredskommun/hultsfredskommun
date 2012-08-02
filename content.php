<?php
/**
 * The default template for displaying content
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
?>
	<article id="post-<?php the_ID(); ?>" <?php post_class((is_sticky())?"sticky":""); ?>>
		<?php if (!is_single()) : ?>
		<div class="readMoreContainer">
			<div class="readMoreContent">
				<div class="summary-content">
					<header class="entry-header">
						<?php if ( is_sticky() ) : ?>
							<hgroup>
								<h2 class="entry-title"><a post_id="<?php the_ID(); ?>" href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'twentyeleven' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
								<h3 class="entry-format"><?php _e( 'Featured', 'twentyeleven' ); ?></h3>
							</hgroup>
						<?php else : ?>
							<h1 class="entry-title"><a post_id="<?php the_ID(); ?>" href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'twentyeleven' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
						<?php endif; ?>

						<?php if ( comments_open() && ! post_password_required() ) : ?>
						<div class="comments-link">
							<?php comments_popup_link( '<span class="leave-reply">' . __( 'Reply', 'twentyeleven' ) . '</span>', _x( '1', 'comments number', 'twentyeleven' ), _x( '%', 'comments number', 'twentyeleven' ) ); ?>
						</div>
						<?php endif; ?>
					</header><!-- .entry-header -->

					<div class="entry-content">
						<?php the_excerpt(); ?>
					</div><!-- .entry-content -->
					<div class="readMoreFadeBottom"></div>
				</div>
			</div>
		</div>
		<a class="readMoreToggleButton" href="<?php the_permalink(); ?>">. . .</a>
		<?php else : // if is_single ?>
			<?php require("single_content.php"); ?>
		<?php endif; ?>

	</article><!-- #post-<?php the_ID(); ?> -->
