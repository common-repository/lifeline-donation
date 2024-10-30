<?php

get_header();

$page_meta =  get_post_meta( get_the_ID(), 'project_settings', true );

$sidebar = (webinane_set($page_meta, 'metaSidebar')) ? webinane_set($page_meta, 'metaSidebar') : '';

$layout = (webinane_set($page_meta, 'layout')) ? webinane_set($page_meta, 'layout') : '';

$span = ($sidebar && ($layout == 'left' || $layout == 'right')) ? 'col-md-9' : 'col-md-12';

$donation_needed = (webinane_set($page_meta, 'donation')) ? webinane_set($page_meta, 'donation') : 0;

if (class_exists('Webinane_Resizer')) {
	$img_obj = new Webinane_Resizer();
} else {
	$img_obj = new stdClass;
}

?>

<section itemscope itemtype="http://schema.org/BlogPosting" class="wpcm-wrapper">

	<div class="block gray urgent-popup-list">

		<div class="wpcm-container">

			<div class="wpcm-row">
				<?php if ($sidebar && $layout == 'left' && is_active_sidebar($sidebar)) : ?>
					<?php webinane_donation_template_load( 'post-templates/sidebar.php', compact( 'sidebar' ) ); ?>	
				<?php endif; ?>

				<div class="<?php echo sanitize_html_class($span); ?> column">
					<?php webinane_donation_template_load( 'post-templates/main-content.php', compact( 'img_obj', 'page_meta','donation_needed' ) ); ?>	
				</div>

				<?php if ($sidebar && $layout == 'right' && is_active_sidebar($sidebar)) : ?>
					<?php webinane_donation_template_load( 'post-templates/sidebar.php', compact( 'sidebar' ) ); ?>
				<?php endif; ?>

			</div>

		</div>

	</div>

</section>

<?php
wp_enqueue_script( array('select2', 'knob', 'element-ui', 'lifeline-donation-modal') );
get_footer();