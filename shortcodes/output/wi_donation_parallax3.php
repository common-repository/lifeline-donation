<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
/**
 * Shortcode attributes
 * @var $atts
 * @var WPBakeryShortCode_Vc_Btn $this
 */
wp_enqueue_style( 'webinane-shortcodes');
wp_enqueue_script(array('lifeline-donation-modal'));

$atts = wi_donation_shortcode_atts( 'wi_donation_parallax3', $atts );
extract( $atts );
$html = wp_kses_allowed_html( 'post' );
?>

<div class="wpcm-wrapper">
	<div class="wpcm-container urgent-popup-list">
		<div class="wpcm-donation-style2">
			<div class="wpcm-row">
				<div class="wpcm-col-lg-7">
					<div class="donation-style2-content">
						<h2><?php echo wp_kses( $title, $html ); ?></h2>
						<p><?php echo wp_kses( $text, $html ); ?></p>
						<div class="donation-style2-btns">
							<?php if( $button ) {
									if ( $action == 'link_add' && $link ) {
										$link_ = ( '||' === $link ) ? '' : $link;  
										$link_n = vc_build_link( $link_ ); 
										$target = $link_n['target'] ? 'target=_blank' : '';
										echo '<a href="'. esc_url( $link_n['url'] ).'" class="wpcm-btn wpcm-btn-radius wpcm-btn-blk" >' . $btn_label . '</a>';
									} elseif($post_id) {
										echo '
										<donation-button :id="'.esc_attr($post_id).'">
											<a href="#" class="wpcm-btn wpcm-btn-radius wpcm-btn-blk donation-modal-box-callerrrr">' . $btn_label . '</a>
										</donation-button>
										';
									} 
							}?>
							<?php if( $button2 ) {
								if ( $action2 == 'link_add' && $link2 ) {
									$link_ = ( '||' === $link2 ) ? '' : $link2;  
									$link_n = vc_build_link( $link_ ); 
									$target = $link_n['target'] ? 'target=_blank' : '';
									echo '<a href="'. esc_url( $link_n['url'] ).'" class="wpcm-btn wpcm-btn-radius wpcm-btn-blk" >' . $btn_label2 . '</a>';
								} elseif($post_id) {
									echo '
									<donation-button :id="'.esc_attr($post_id).'">
										<a href="" class="wpcm-btn wpcm-btn-radius wpcm-btn-blk donation-modal-box-callerrrr">' . esc_attr($btn_label2) . '</a>
									</donation-button>
									';
								} 
							} ?>
						</div>
						<div class="wpcm-icon-box">
							<span><i class="flaticon-hands-and-gestures"></i></span>
						</div>	
					</div>
				</div>
				<div class="wpcm-col-lg-5">
					<div class="donation-style2-img">
						<figure>
							<?php echo wp_get_attachment_image( $side_image, 'full' ); ?>
						</figure>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>