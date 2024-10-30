<?php
    $html = wp_kses_allowed_html('post');
    $settings = wpcm_get_settings();
?>
    <div class="wpcm-wrapper">
        <slot>
            <div class="donation-modal-box">
                <div class="donation-popup" style="display: block;" v-loading="loading">
                    <div class="wpcm-container">
                    
                        <div class="popup-centralize">
                            <span class="closep" @click.prevent="closePopup()"><i class="fas fa-times"></i></span>

                            <div class="fixed-bg" v-if="post_id" style="background:url(<?php echo esc_url(wp_get_attachment_url(wpcm_get_settings()->get('donation_Cpost_bg'))); ?>) repeat scroll 0 0 rgba(0, 0, 0, 0);" data-velocity="-.1"></div><!-- PARALLAX BACKGROUND IMAGE -->
                            <div class="fixed-bg" v-else style="background:url(<?php echo esc_url(wp_get_attachment_url(wpcm_get_settings()->get('donation_general_bg'))); ?>) repeat scroll 0 0 rgba(0, 0, 0, 0);" data-velocity="-.1"></div><!-- PARALLAX BACKGROUND IMAGE -->
                            <div class="donation-intro">
                                <?php if (wpcm_get_settings()->get('donation_calculation_bar') === true) : ?>
                                <div class="wpcm-row">
                                    <div class="wpcm-col-md-4">
                                        <div class="make-donation">
                                            <span><?php echo wp_kses(wpcm_get_settings()->get('donation_genral_subtitle'), $html); ?></span>
                                            <h5 v-if="title" v-html="title"></h5>
                                            <p v-if="text" v-html="text"></p>
                                        </div><!-- Make Donation -->
                                
                                    </div>
                                    <?php $symbol =  webinane_currency_symbol(); ?>
                                    <div class="wpcm-col-md-8" v-if="needed_amt.amt">
                                        <div class="select-cause">
                                            <div class="urgent-progress">
                                                <div class="wpcm-row">
                                                    <div class="wpcm-col-md-4">
                                                        <div class="amount"><span v-html="collected_amt.formated" class="amount-return"></span><span><?php esc_html_e('Current Collection', 'lifeline-donation'); ?></span></div>
                                                    </div>
                                                    <div class="wpcm-col-md-4">
                                                        <div class="amount"> <span v-html="needed_amt.formated" class="amount-return"></span><span><?php esc_html_e('Target Needed', 'lifeline-donation'); ?></span></div>
                                                    </div>
                                                    <div class="wpcm-col-md-offset-1 wpcm-col-md-3">
                                                        <div class="circular" v-show="collected_amt"><input class="knob" data-fgColor="#d8281b" data-bgColor="#dddddd" data-thickness=".10" readonly :value="((parseInt(collected_amt.amt)/parseInt(needed_amt.amt))*100).toFixed(0)"/><span><?php esc_html_e('Completed', 'lifeline-donation'); ?></span></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- Select Cause -->
                                    </div>
                                </div>
                                <?php else : ?>
                                <div class="wpcm-row" style="text-align: center;">
                                    <div class="wpcm-col-md-12">
                                        <div class="make-donation">
                                            <span><?php echo wp_kses($settings->get('donation_genral_subtitle'), $html); ?></span>
                                            <h5 v-if="title" v-html="title"></h5>
                                            <p v-if="text" v-html="text"></p>
                                        </div><!-- Make Donation -->
                                     
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div><!-- Donation Intro -->
                            
                            <div class="payment-box">
                                <?php if ($settings->get('donation_recurring_payments')) : ?>
                                    <ul class="frequency">
                                        <li>
                                            <a href="#" @click.prevent="step = 1;recurring = true" :class="(recurring) ? 'active' : ''"><?php esc_html_e('Recurring', 'lifeline-donation'); ?></a>
                                        </li>
                                        <li>
                                            <a href="#" @click.prevent="step = 1;recurring = false" :class="(!recurring) ? 'active' : ''"><?php esc_html_e('One Time', 'lifeline-donation'); ?></a>
                                        </li>
                                    </ul><!-- Frequency -->
                                <?php endif; ?>
                                <div class="paragraph_default"></div>
                                <div id="step1-error1"></div>

                                <transition name="fade">
                                    <div class="donation-fields donation-step1" v-show="step == 1">
                                        <?php include LIFELINE_DONATION_PATH . 'templates/donation-modal/currency.php' ?>
                                    </div>
                                </transition>
                                <div id="step2-error1"></div>
                                <transition name="fade">
                                    <div class="donation-fields donation-step2" v-show="step == 2">
                                        <?php include LIFELINE_DONATION_PATH . 'templates/donation-modal/payment-methods.php' ?>
                                    </div>
                                </transition>
                            </div><!-- Payment Box -->
                        </div><!-- Popup Centralize -->
                    </div>
                </div><!-- Donation Popup -->
            </div>
        </slot>
    </div>