<?php
if (! defined('ABSPATH')) {
    die('-1');
}
/**
 * Shortcode attributes
 * @var $atts
 * @var WPBakeryShortCode_Vc_Btn $this
 */
$html = wp_kses_allowed_html('post');
wp_enqueue_style('webinane-shortcodes');
wp_enqueue_script(array('lifeline-donation-modal'));

$atts = wi_donation_shortcode_atts('wi_donation_campaigns3', $atts);
extract($atts);

$post_type = $post ? $post : 'cause';
$args = array(
    'post_type'      => $post_type,
    'order'          => $order,
    'posts_per_page' => $num,
);

$cat_type = ( $post == 'cause' ) ? $cat1 : $cat2;
$cat_slug  = ( $post == 'cause' ) ? 'cause_cat' : 'project_cat';
$cat = explode(',', $cat_type);
if (!empty($cat) && webinane_set($cat, 0) == 'all') {
    array_shift($cat);
}

if (!empty($cat) && webinane_set($cat, 0) != '') {
    $args['tax_query'] = array(array('taxonomy' => $cat_slug, 'field' => 'slug', 'terms' => (array) $cat));
}

$query = new WP_Query($args);

if ($query->have_posts()) :  ?>
     <div class="wpcm-wrapper">
        <div class="wpcm-container urgent-popup-list">
            <div class="wpcm-row">
                <?php $counter = 0;
                while ($query->have_posts()) :
                    $query->the_post();
                    $meta_key = ($post == 'cause' ) ? 'causes_settings' : 'project_settings';
                    $meta = get_post_meta(get_the_ID(), $meta_key, true);
                    $donation_needed = (webinane_set($meta, 'donation')) ? webinane_set($meta, 'donation') : 0;
                    $collect_amt = WebinaneCommerce\Classes\Orders::get_items_total(get_post(get_the_ID()));
                    if ($collect_amt != 0 && $donation_needed != 0) {
                        $donation_percentage = ($collect_amt/$donation_needed)*100;
                    } else {
                        $donation_percentage = 0;
                    } ?>
                    <div class="wpcm-col-lg-4 wpcm-col-md-6">
                        <div class="wpcm-cause-style3">
                            <div class="wpcm-cause-style3-img">
                                <figure>
                                    <?php the_post_thumbnail([350, 546]); ?>
                                </figure>
                                <div class="wpcm-cause-style3-contnt">
                                    <?php if (webinane_set($meta, 'location')) : ?>
                                        <span class="wpcm-cause-loc"><?php echo esc_html(webinane_set($meta, 'location')); ?></span>
                                    <?php endif; ?>
                                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                                    <span><strong><?php esc_html_e('Raised:', 'lifeline-donation'); ?> </strong>  <?php echo webinane_cm_price_with_symbol($collect_amt); ?></span>
                                    <?php if ($button) : ?>
                                        <?php  if ($action == 'detail') : ?>
                                            <a href="<?php the_permalink(); ?>" class="wpcm-btn wpcm-btn-green"><?php echo esc_html($btn_label); ?></a>
                                        <?php else : ?>
                                            <donation-button :id="<?php the_ID() ?>">
                                                <a href="#" class="donation-modal-box-callerrrr wpcm-btn wpcm-btn-green"><?php echo esc_html($button_label) ? $button_label : esc_html_e('Donate Now', 'lifeline-donation'); ?></a>
                                            </donation-button>
                                        <?php endif; ?>
                                        
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile;
                wp_reset_postdata(); ?>
            </div>
        </div>
    </div>
<?php endif; ?>
