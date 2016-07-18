<?php
/**
 * The theme's 404 page for showing not found pages.
 *
 * @since 1.0.0
 * @package RealBigPlugins
 */

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

get_header();

the_post();
?>

	<div class="page-content row">

		<article id="page-404" class="columns small-12">

			<h1 class="page-title">
				404 - Not Found
			</h1>

			<p>
				Sorry, but there's nothing here.
			</p>

		</article>

	</div>

<?php
get_footer();