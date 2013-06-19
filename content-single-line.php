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
	<li id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<a href="<?php the_permalink(); ?>" class="link" title="<?php echo get_the_excerpt(); // printf( esc_attr__( 'Permalink to %s', 'twentyeleven' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
		<span class='hidden article_id'><?php the_ID(); ?></span>
	</li><!-- #post-<?php the_ID(); ?> -->
