<?php
if (! defined('ABSPATH')) {
    die('-1');
}
/**
 * Shortcode attributes
 * @var $atts
 * @var WPBakeryShortCode_Vc_Btn $this
 */
wp_enqueue_style(array('webinane-shortcodes', 'webinane-flat-icon'));
wp_enqueue_script(array('lifeline-donation-modal'));
$html = wp_kses_allowed_html('post');

$atts = wi_donation_shortcode_atts('wi_donation_parallax2', $atts);

extract($atts);

?>

<div class="wpcm-wrapper">
    <div class="wpcm-container">
        <div class="wpcm-row">
            <div class="wpcm-col-lg-12">
                <div class="wpcm-donation-style1 text-center wpcm-p-100 urgent-popup-list">
                    <div class="donation-style1-inner">
                        <i class="flaticon-honest"></i>
                        <h2><?php echo wp_kses($title, $html); ?></h2>
                        <span><?php echo wp_kses($sub_title, $html); ?></span>
                        <?php  if ($button) {
                            if ($action == 'link_add' && $link) {
                        		// @codingStandardsIgnoreLine
                        			$link_ = ( '||' === $link ) ? '' : $link;  
                                    $link_n = vc_build_link($link_);
                                echo '<a href="'. esc_url($link_n['url']).'" class="wpcm-btn wpcm-btn-icon wpcm-btn-red"><span><i class="flaticon-hand"></i></span>' . esc_attr($btn_label) . '</a>';
                            } elseif($post_id) {
                        		// @codingStandardsIgnoreLine
                        		echo '
                                <donation-button :id="'.esc_attr($post_id).'">
                                    <a href="#" class="wpcm-btn wpcm-btn-icon wpcm-btn-red donation-modal-box-callerrrr"><span><i class="flaticon-hand"></i></span>' . esc_attr($btn_label) . '</a>
                                </donation-button>
                                ';
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
