<?php
/**
 * Functions to register client-side assets (scripts and stylesheets) for the
 * Gutenberg block.
 *
 * @package lifeline-donation
 */

/**
 * Registers all block assets so that they can be enqueued through Gutenberg in
 * the corresponding context.
 *
 * @see https://wordpress.org/gutenberg/handbook/designers-developers/developers/tutorials/block-tutorial/applying-styles-with-stylesheets/
 */
function wi_donation_campaigns3_block_init() {
	// Skip block registration if Gutenberg is not enabled/merged.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}
	$dir = dirname( __FILE__ );

	$index_js = 'campaigns3/index.js';
	wp_register_script(
		'wi_donation_campaigns3-block-editor',
		plugins_url( $index_js, __FILE__ ),
		array(
			'wp-blocks',
			'wp-i18n',
			'wp-element',
			'wp-editor',
			'wp-plugins',
            'wp-edit-post',
            'wp-data',
            'underscore'
		),
		filemtime( "$dir/$index_js" )
	);

	$editor_css = 'campaigns3/editor.css';
	wp_register_style(
		'wi_donation_campaigns3-block-editor',
		plugins_url( $editor_css, __FILE__ ),
		array(),
		filemtime( "$dir/$editor_css" )
	);

	$style_css = 'campaigns3/style.css';
	wp_register_style(
		'wi_donation_campaigns3-block',
		plugins_url( $style_css, __FILE__ ),
		array(),
		filemtime( "$dir/$style_css" )
	);

	register_block_type( 'lifeline-donation/campaigns3', array(
		'editor_script' => 'wi_donation_campaigns3-block-editor',
		'editor_style'  => 'wi_donation_campaigns3-block-editor',
		'render_callback'	=> 'wi_donation_campaigns3_render_callback'
	) );
}
add_action( 'init', 'wi_donation_campaigns3_block_init' );

function wi_donation_campaigns3_render_callback($atts, $output) {

	wp_enqueue_script(array('lifeline-donation-modal'));
	$html = wp_kses_allowed_html( 'post' );

	$arr = webinane_array($atts);
	$query = new WP_Query(array(
		'post_type'			=> $arr->get('source', 'cause'),
		'posts_per_page' 	=> $arr->get('number', 2),
		'order' 			=> $arr->get('order', 'DESC'),
		'orderby' 			=> $arr->get('orderBy', 'date'),
	));

	ob_start();
	?>
	<?php if( $query->have_posts() ) : ?>
		<section class="wpcm-wrapper wp-block-lifeline-donation-campaigns3 urgent-popup-list">
			<div class="wpcm-row">
				<?php while($query->have_posts() ) : $query->the_post() ?>

					<?php 
						global $post;
						$meta = get_post_meta(get_the_id(), get_post_type().'s_settings', true);
						$location = webinane_set($meta, 'location');
						$total = \WebinaneCommerce\Classes\Orders::get_items_total($post);
						$needed = webinane_set($meta, 'donation');
						$percent = ($needed) ? ((int)$total/(int)$needed)*100 : 0;
					?>
					<div class="wpcm-col-lg-4 wpcm-col-md-6">

						<div class="wpcm-cause-style3">
							<div class="wpcm-cause-style3-img">
								<figure>
									<?php the_post_thumbnail( array(370, 475) ) ?>
								</figure>
								<div class="wpcm-cause-style3-contnt">
									<span class="wpcm-cause-loc"><?php echo sanitize_text_field($location); ?></span>
									<h2>
										<a href="<?php the_permalink() ?>" title="<?php the_title_attribute() ?>">
											<?php the_title() ?>
										</a>
									</h2>
									<span><strong><?php esc_html_e('Raised:', 'lifeline-donation'); ?> </strong>  <?php echo wp_kses(webinane_cm_price_with_symbol($total), $html) ?></span>
									<a href="#" @click.prevent="showModal(<?php the_ID() ?>,$event)" class="wpcm-btn wpcm-btn-green"><?php esc_html_e('Donate Now', 'lifeline-donation'); ?></a>
								</div>
							</div>
						</div>
					</div>
				<?php endwhile; ?>
			</div>
		</section>
	<?php

	endif;
	$content = ob_get_clean();

	wp_reset_postdata();

	return $content;
}