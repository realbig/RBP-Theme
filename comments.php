<?php
/**
 * The theme's comment template file.
 *
 * @since   1.0.0
 * @package RealBigPlugins
 */

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

if ( post_password_required() ) { ?>
	<p class="nocomments"><?php _e( 'This post is password protected. Enter the password to view comments.' ); ?></p>
	<?php
	return;
}
?>

<!-- You can start editing here. -->

<?php if ( have_comments() ) : ?>
	<h3 id="comments"><?php printf( _n( 'One Response to %2$s', '%1$s Responses to %2$s', get_comments_number() ),
			number_format_i18n( get_comments_number() ), '&#8220;' . get_the_title() . '&#8221;' ); ?></h3>

	<div class="navigation">
		<div class="alignleft"><?php previous_comments_link() ?></div>
		<div class="alignright"><?php next_comments_link() ?></div>
	</div>

	<ol class="commentlist">
		<?php wp_list_comments(); ?>
	</ol>

	<div class="navigation">
		<div class="alignleft"><?php previous_comments_link() ?></div>
		<div class="alignright"><?php next_comments_link() ?></div>
	</div>
<?php else : // this is displayed if there are no comments so far ?>

	<?php if ( comments_open() ) : ?>
		<!-- If comments are open, but there are no comments. -->

	<?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		<p class="nocomments"><?php _e( 'Comments are closed.' ); ?></p>

	<?php endif; ?>
<?php endif; ?>

<?php if ( comments_open() ) : ?>

	<div id="respond">

		<h3><?php comment_form_title( __( 'Leave a Reply' ), __( 'Leave a Reply to %s' ) ); ?></h3>

		<div id="cancel-comment-reply">
			<?php cancel_comment_reply_link() ?>
		</div>

		<?php if ( get_option( 'comment_registration' ) && ! is_user_logged_in() ) : ?>
			<p>
				<?php
				printf(
					__( 'You must be <a href="%s">logged in</a> to post a comment.' ),
					wp_login_url( get_permalink() )
				);
				?>
			</p>
		<?php else : ?>

			<form action="<?php echo site_url(); ?>/wp-comments-post.php" method="post" id="commentform" data-abide novalidate>

				<?php if ( is_user_logged_in() ) : ?>

					<p>
						<?php printf( __( 'Logged in as <a href="%1$s">%2$s</a>.' ), get_edit_user_link(), $user_identity ); ?>
						<a href="<?php echo wp_logout_url( get_permalink() ); ?>"
						   title="<?php esc_attr_e( 'Log out of this account' ); ?>"><?php _e( 'Log out &raquo;' ); ?></a>
					</p>

				<?php else : ?>

					<label>
						<?php _e( 'Author' ); ?>
						<input type="text" name="author" required
						       value="<?php echo esc_attr( $comment_author ); ?>"
						       size="22" tabindex="1" <?php if ( $req ) {
							echo "aria-required='true'";
						} ?> />
						<small class="error">Required</small>
					</label>

					<label>
						<?php _e( 'Email' ); ?>
						<input type="text" name="email" required pattern="email"
						       value="<?php echo esc_attr( $comment_author_email ); ?>" size="22"
						       tabindex="2" <?php if ( $req ) {
							echo "aria-required='true'";
						} ?> />
						<small class="error">Required and must be email format</small>
					</label>


				<?php endif; ?>

				<label>
					<?php _e( 'Comment' ); ?>
					<textarea name="comment" id="comment" cols="58" rows="5" tabindex="4" required></textarea>
					<small class="error">Required</small>
				</label>

				<p>
					<?php printf( __( '<strong>XHTML:</strong> You can use these tags: <code>%s</code>' ), allowed_tags() ); ?>
				</p>

				<p>
					<input type="submit" name="submit" id="submit" tabindex="5" value="Submit Comment" class="button secondary alignright" />
					<?php comment_id_fields(); ?>
				</p>
				<?php
				/** This filter is documented in wp-includes/comment-template.php */
				do_action( 'comment_form', $post->ID );
				?>

			</form>

		<?php endif; // If registration required and not logged in ?>
	</div>

<?php endif; // if you delete this the sky will fall on your head ?>
