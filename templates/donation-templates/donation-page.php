<?php
/**
 * Donation page shortocde templates.
 *
 * @package WordPress
 */

$html = wp_kses_allowed_html( 'post' );
$settings = wpcm_get_settings();
?>
<div class="custom-dropp wpcm-wrapper lifeline-donation-page post-detail-page" pid="<?php echo esc_attr( $id ); ?>">
	
		<div class="donation-modal-box" >
			<div class="" style="display: block;">
				<div class="wpcm-container">
				
					<div class="popup-centralized">
						
						<div class="fixed-bg" v-if="post_id" style="background:url(<?php echo esc_url( wp_get_attachment_url( wpcm_get_settings()->get( 'donation_Cpost_bg' ) ) ); ?>) repeat scroll 0 0 rgba(0, 0, 0, 0);" data-velocity="-.1"></div><!-- PARALLAX BACKGROUND IMAGE -->
						<div class="fixed-bg" v-else style="background:url(<?php echo esc_url( wp_get_attachment_url( wpcm_get_settings()->get( 'donation_general_bg' ) ) ); ?>) repeat scroll 0 0 rgba(0, 0, 0, 0);" data-velocity="-.1"></div><!-- PARALLAX BACKGROUND IMAGE -->
						<div class="donation-intro">
							<div class="wpcm-row">
								<div class="wpcm-col-lg-4 wpcm-col-md-12">
									<?php if ( $title ) : ?>
										<div class="make-donation">
											<h5><?php echo wp_kses( $title, $html ); ?></h5>
											<p><?php echo wp_kses( $content, $html ); ?> </p> 
										</div><!-- Make Donation -->
									<?php else : ?>
										<div class="make-donation" v-if="title">
											<span v-if="false">{{ title }}</span>
											<h5 v-if="title">{{ title }}</h5>
											<p v-if="text" v-html="text"></p>
										</div><!-- Make Donation -->
									<?php endif; ?>
								</div>
								<?php $symbol = webinane_currency_symbol(); ?>
								<div class="wpcm-col-lg-8 wpcm-col-md-12" v-if="needed_amt.amt">
									<div class="select-cause">
										<div class="urgent-progress">
											<div class="wpcm-row">
												<div class="wpcm-col-md-4">
													<div class="amount"><span v-html="collected_amt.formated" class="amount-return"></span><span><?php esc_html_e( 'Current Collection', 'lifeline-donation' ); ?></span></div>
												</div>
												<div class="wpcm-col-md-4">
													<div class="amount"> <span v-html="needed_amt.formated" class="amount-return"></span><span><?php esc_html_e( 'Target Needed', 'lifeline-donation' ); ?></span></div>
												</div>
												<div class="wpcm-col-md-offset-1 wpcm-col-md-3">
													<?php if ( $settings->get('donation_calculation_bar') ) : ?>
														<div class="circular" v-show="collected_amt"><input class="knob" data-fgColor="#d8281b" data-bgColor="#dddddd" data-thickness=".10" readonly :value="((parseInt(collected_amt.amt)/parseInt(needed_amt.amt))*100).toFixed(0)"/><span><?php esc_html_e( 'Completed', 'lifeline-donation' ); ?></span></div>
													<?php endif; ?>
												</div>
											</div>
										</div>
									</div><!-- Select Cause -->
								</div>

							</div>
						</div><!-- Donation Intro -->
						<div class="paragraph_default hide"><p><?php esc_html_e( 'Please Select the payment type', 'lifeline-donation' ); ?></p></div>
						<div class="payment-box">

							<ul class="frequency">
								<li>
									<a href="#" @click.prevent="step = 1;recurring = true" :class="(recurring) ? 'active' : ''"><?php esc_html_e( 'Recurring', 'lifeline-donation' ); ?></a>
								</li>
								<li>
									<a href="#" @click.prevent="step = 1;recurring = false" :class="(!recurring) ? 'active' : ''"><?php esc_html_e( 'One Time', 'lifeline-donation' ); ?></a>
								</li>
							</ul><!-- Frequency -->
							<div class="paragraph_default"></div>
							<div id="step1-error1"></div>

							<transition name="fade">
								<div class="donation-fields donation-step1" v-show="step == 1">
									<?php include LIFELINE_DONATION_PATH . 'templates/donation-modal/currency.php'; ?>
								</div>
							</transition>
							
							<div id="step2-error1"></div>
							<transition name="fade">
								<div class="donation-fields donation-step2" v-show="step == 2">
									<?php include LIFELINE_DONATION_PATH . 'templates/donation-modal/payment-methods.php'; ?>
								</div>
							</transition>
						</div><!-- Payment Box -->
					</div><!-- Popup Centralize -->
				</div>
			</div><!-- Donation Popup -->


		</div>
	
</div>
