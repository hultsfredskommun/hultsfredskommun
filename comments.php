<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to twentyeleven_comment() which is
 * located in the functions.php file.
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
?>
<?php if ( $_REQUEST["thanks"] == get_the_ID()) : ?>

	<div id="comment" class="thanks-message" >
		Tack f&ouml;r ditt meddelande.
	</div>

<?php elseif ( $_REQUEST["respond"] == get_the_ID()) : ?>

	<div id="comments">
	<?php if ( post_password_required() ) : ?>
		<p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'twentyeleven' ); ?></p>
	</div><!-- #comments -->
	<?php
			/* Stop the rest of comments.php from being processed,
			 * but don't kill the script entirely -- we still have
			 * to fully load the template.
			 */
			return;
		endif;
	?>

	<?php // You can start editing here -- including this comment! ?>
	<?php 
		global $current_user;
	?>

	<?php comment_form(array('title_reply' => "Kontakta sidansvarig",
	'fields' => apply_filters( 'comment_form_default_fields', array(
		'author' => '<p class="comment-form-author">' . '<input name="redirect_to" type="hidden" value="' . get_permalink() . '?thanks=' . get_the_ID() . '"/><label for="author">Namn ' . ( $req ? '<span class="required">*</span>' : '' ) . '</label><input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></p>',
		'email' => '<p class="comment-form-email"><label for="email">E-post ' . ( $req ? '<span class="required">*</span>' : '' ) . '</label><input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></p>',
		) ), 
	'comment_notes_before' => 'Fyll i namn och e-post om du vill bli kontaktad.',
	'comment_field' => '<p class="comment-form-comment"><label for="comment">Meddelande</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>',
	'label_submit' => 'Skicka meddelande',
	'comment_notes_after' => '',
	));  ?>

</div><!-- #comments -->
<?php endif; // end if request respond != "" ?>