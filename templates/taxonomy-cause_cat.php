<?php
get_header();
if (class_exists('Webinane_Resizer')) {
	$img_obj = new Webinane_Resizer();
} 
?>

<section class="wpcm-wrapper">

	<div class="block gray">

		<div class="wpcm-container">

			<div class="wpcm-row">

				<?php if ( wpcm_get_settings()->get('archive_sidebar_layout') == 'left' && is_active_sidebar( wpcm_get_settings()->get('cause_archive_sidebar') ) ) : ?>

					<aside class="wpcm-col-md-3 column sidebar">

						<?php dynamic_sidebar( wpcm_get_settings()->get('cause_archive_sidebar') ); ?>

					</aside>

				<?php endif; ?>

				<div class="<?php echo sanitize_html_class( ( wpcm_get_settings()->get('archive_sidebar_layout') == 'left' || wpcm_get_settings()->get('archive_sidebar_layout') == 'right' ) ) ? 'col-md-9' : 'col-md-12'; ?> column">

					<div class="blog-list list-style">

						<div class="row">
							<?php

							if ( have_posts() ) :

								while ( have_posts() ) : the_post();
									webinane_donation_template_load( 'post-templates/archive_template.php', compact( 'img_obj' ) );                             
								endwhile; wp_reset_postdata();
							endif;
							?>

						</div>

					</div><!-- Blog List -->

				</div>

				<?php if ( wpcm_get_settings()->get('archive_sidebar_layout') == 'right' && is_active_sidebar( wpcm_get_settings()->get('cause_archive_sidebar') ) ) : ?>

					<aside class="wpcm-col-md-3 column sidebar">

						<?php dynamic_sidebar( wpcm_get_settings()->get('cause_archive_sidebar') ); ?>

					</aside>

				<?php endif; ?>

			</div>

		</div>

	</div>

</section>



<?php 
wp_enqueue_script( array('select2', 'knob', 'element-ui', 'lifeline-donation-modal') );
get_footer();

