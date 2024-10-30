<?php
if (! defined('ABSPATH')) {
    die('-1');
}
/**
 * Shortcode attributes
 * @var $atts
 * @var WPBakeryShortCode_Vc_Btn $this
 */
wp_enqueue_style('webinane-shortcodes');
wp_enqueue_script(array('lifeline-donation-modal'));

$atts = wi_donation_shortcode_atts('wi_donation_parallax', $atts);
// printr($atts);
extract($atts);
$html = wp_kses_allowed_html('post');
?>
<div class="wpcm-wrapper">
    <div class="wpcm-campaign-parallax" style="background: url('<?php echo wp_get_attachment_thumb_url($bg_image); ?>') no-repeat;"></div>
    <div class="wpcm-container">
        <div class="wpcm-row">
            <div class="wpcm-col-lg-12">
                <div class="campaign-para-content text-center wpcm-p-150">
                    <i class="flaticon-love-and-romance"></i>
                    <h2><?php echo wp_kses($title, $html); ?></h2>
                    <p><?php echo wp_kses($text, $html); ?></p>
                
                    <?php  if ($button) {
                        if ($action == 'link_add' && $link) {
                    		// @codingStandardsIgnoreLine
                    			$link_ = ( '||' === $link ) ? '' : $link;  
                                $link_n = vc_build_link($link_);
                            echo '<a href="'. esc_url($link_n['url']).'" class="wpcm-btn wpcm-btn-radius wpcm-btn-yellow">' . $btn_label . '</a>';
                        } else {
                    		// @codingStandardsIgnoreLine
                            
                    		echo '
                                <div class=" urgent-popup-list">
                                <donation-button :id="'.esc_attr($post_id).'">
                                    <a class="wpcm-btn wpcm-btn-radius wpcm-btn-yellow donation-modal-box-callerrrr"  href="#">' . $btn_label . '</a>
                                </donation-button></div>';
                        }
                    }
                    ?>
                    <?php  if ($button2) : ?>
                        <div class="wpcm-donte-btn">
                            <span><?php esc_html_e('or', 'lifeline-donation'); ?>
                            
                            <?php if ($action2 == 'link' && $link2) {
                        		// @codingStandardsIgnoreLine
                        			$link_ = ( '||' === $link2 ) ? '' : $link2;  
                                    $link_n = vc_build_link($link_);
                                echo '<a href="'. esc_url($link_n['url']).'">' . $btn_label . '</a>';
                            } else {
                        		// @codingStandardsIgnoreLine
                        		echo '<div class=" urgent-popup-list"><donation-button :id="'.esc_attr($post_id2).'">
                                <a class="donation-modal-box-callerrrr"  href="#">' . $btn2_label . '</a>
                                </donation-button></div>';
                            } ?>
                            </span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>  
</div>
