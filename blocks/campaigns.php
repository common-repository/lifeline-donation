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
function wi_donation_campaigns_block_init() {
	// Skip block registration if Gutenberg is not enabled/merged.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}
	$dir = dirname( __FILE__ );

	$index_js = 'campaigns/index.js';

	wp_register_script(
		'donation-campaigns-block-editor',
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

	$editor_css = 'campaigns/editor.css';
	wp_register_style(
		'donation-campaigns-block-editor',
		plugins_url( $editor_css, __FILE__ ),
		array(),
		filemtime( "$dir/$editor_css" )
	);

	$style_css = 'campaigns/style.css';
	wp_register_style(
		'donation-campaigns-block',
		plugins_url( $style_css, __FILE__ ),
		array(),
		filemtime( "$dir/$style_css" )
	);

	register_block_type( 'lifeline-donation/campaigns', array(
		'editor_script' => 'donation-campaigns-block-editor',
		'editor_style'  => 'donation-campaigns-block-editor',
		//'style'         => 'donation-campaigns-block',
		'render_callback'	=> 'wi_donation_campaigns_render_callback'
	) );
}
add_action( 'init', 'wi_donation_campaigns_block_init' );

function wi_donation_campaigns_render_callback($atts, $output) {
	$html = wp_kses_allowed_html( 'post' );
	wp_enqueue_script(array('lifeline-donation-modal'));

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
		<section class="wpcm-wrapper urgent-popup-list wp-block-lifeline-donation-campaigns">
			<div class="wpcm-row">
				<?php while($query->have_posts() ) : $query->the_post() ?>

					<?php 
						global $post;
						$meta = get_post_meta(get_the_id(), get_post_type().'s_settings', true);
						$total = \WebinaneCommerce\Classes\Orders::get_items_total($post);
						$needed = webinane_set($meta, 'donation');
						$percent = ($needed) ? ((int)$total/(int)$needed)*100 : 0;
					?>
					<div class="wpcm-cause-listng">
						<div class="wpcm-row align-items-center">
							<div class="wpcm-col-lg-6 wpcm-col-md-6">
								<div class="wpcm-cause-lstng-img">
									<figure>
										<?php the_post_thumbnail( 'wi_donation_460x490' ) ?>
									</figure>
									<a href="#" @click.prevent="showModal(<?php the_ID() ?>, $event)" data-post="<?php the_ID() ?>" class="wpcm-btn wpcm-btn-icon wpcm-btn-green2"><span><i class="flaticon-hand"></i></span><?php esc_html_e('Donate Now', 'lifeline-donation'); ?></a>
								</div>
							</div>
							<div class="wpcm-col-lg-6 wpcm-col-md-6">
								<div class="wpcm-cause-lsting-contnt">
									<a href="#" title="" class="wpcm-cause-cat">water</a>
									<h2><a href="<?php the_permalink() ?>" title="<?php the_title_attribute() ?>"><?php the_title() ?></a></h2>
									<p><?php echo wp_trim_words( get_the_excerpt(), 10 ) ?></p>
									<span><?php esc_html_e('Raised', 'lifeline-donation'); ?>:  <strong><?php echo wp_kses(webinane_cm_price_with_symbol($total), $html) ?></strong></span>
									<div class="progress">
									 	<div class="progress-bar" style="width:<?php echo esc_attr($percent) ?>%">
									 		<span><?php echo sanitize_text_field( $percent ) ?>%</span>
									 	</div>
									</div> 
								</div>
							</div>
						</div>
					</div>
				<?php endwhile; ?>
					
			</div>

		</section>
	<?php endif; ?>
	<?php
	$content = ob_get_clean();
	wp_reset_postdata();
	return $content;
}
