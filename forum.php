<?php
/**
 * Template Name: Debattforum
 * Description: Visar upp debattforumet.
 */

 


get_header(); 
?>

	<?php hk_navigation(); ?>
	
	<div id="primary" class="primary">
		<div id="content" role="main">
			<?php if ( have_posts() ) : the_post(); ?>
				<?php
					// get post type
					$post_type = get_post_type();
                    echo "<h1>" . get_the_title() . "</h1>";
                    the_content();
				?>
				<?php //get_template_part( 'content', 'single' ); ?>

			<?php endif; // end of the loop. ?>
			

            <?php
                echo '<h2>Debattinlägg</h2>';

                echo hk_forum();
            ?>


		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
