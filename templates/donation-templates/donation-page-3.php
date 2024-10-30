<?php
/**
 * Donation page 3
 *
 * @package WordPress
 */

$html = wp_kses_allowed_html( 'post' );
$settings = wpcm_get_settings();
$id = ( $id ) ? $id : 0;
?>
<div class="donation-box-wrapper lifeline-donation-page post-detail-page popup-style3 wpcm-wrapper" :pid="<?php echo esc_attr( $id ); ?>">
	<div>
		<div class="donation-box-wrapper">
			<div class="wpcm-row">
				<div class="wpcm-col-md-5">
					<div class="donation-box-wraper-inner">
						<div class="donation-box-title">
							<span><img src="<?php echo LIFELINE_DONATION_URL; ?>/assets/images/new-img.png" alt=""></span>
							<?php if( $title ) : ?>
								<h2><?php echo esc_attr($title) ?></h2>
							<?php else : ?>
								<h2 v-if="title">{{ title }}</h2>
							<?php endif; ?>
						</div>

						<div class="donation-amount-box">
							<el-select v-model="currency" @change="getCurrencySymbol($event)" size="large">
								<el-option v-for="(label, opt_key) in currencies" :key="opt_key" :value="opt_key" :label="label"></el-option>
							</el-select>
							
							<?php if ( webinane_set( $settings, 'enable_custom_dropdown' ) === true && webinane_set( $settings, 'donation_custom_dropdown' ) ) : ?>
								 <div class="el-custom-select custom-drop">
									<el-select v-model="extras.dropdown" size="large">
										<el-option v-for="(label) in dropdown" :key="label" :value="label" :label="label"></el-option>
									</el-select>
								</div>
							<?php endif; ?>

							<div class="custom-donation-amount">
								<span>{{symbol}}</span>
								<input v-model="amount" type="text">
							</div>

							<ul class="list-unstyled">
								<li v-for="amt in amount_slabs" v-if="amount_slabs">
									<a :class="{active: amount == amt, 'wpdonation-button': true}" @click.prevent="amount = amt" href="#" title="">
									{{symbol}}{{amt}}</a>
								</li>
							</ul>
						</div>

						<?php do_action( 'webinane_commerce/popup/before_currencies' ); ?>

						<a href="#" title="" @click.prevent="showModal2(<?php echo esc_attr( $id ); ?>, $event); showModalBox2 = true" class="donation-done"><?php esc_html_e( 'Donate Now', 'lifeline-donation' ); ?></a>
						<div id="step1-error1"></div>
					</div>
				</div>
				<div class="wpcm-col-md-7">
					<?php echo wp_kses( $content, $html ); ?>
				</div>

			</div>
		
		</div>
		
		<div class="wpcm-wrapper footer-donation-modal popup-style3">
			<div class="donation-modal-box" v-show="showModalBox2" style="display: none;">
				<div class="donation-popup" style="display: block;">
					<div class="wpcm-container">
						<span class="closep" @click.prevent="closePopup('2')"><i class="fa fa-remove"></i></span>
						<div class="donation-box-wraper-inner">
							<div class="donation-box-title">
								<img src="images/new-img.png" alt="">
								<h2>New Offical Compaign Starts Today</h2>
							</div>
							<div class="donation-payment-cycle">
								<a href="#" @click.prevent="step = 1;recurring = true" :class="(recurring) ? 'active' : ''"><?php esc_html_e( 'Recurring', 'lifeline-donation' ); ?></a>
								<a href="#" @click.prevent="step = 1;recurring = false" :class="(!recurring) ? 'active' : ''"><?php esc_html_e( 'One Time', 'lifeline-donation' ); ?></a>
							</div>
							<div class="donation-payment-method mt-5 mb-5">
								<a v-for="gatewy in gateways" :class="(payment_method == gatewy.id) ? 'active' : ''" href="#" title="" @click.prevent="payment_method = gatewy.id" v-if="(recurring && gateway.recurring) || !recurring">
									<span v-if="gatewy.icon"><img :src="gatewy.icon" alt=""></span>
									{{ (gatewy.title) ? gatewy.title : gatewy.name }}
								</a>
							</div>
							<?php do_action( 'webinane_checkout_payment_gateway_data' ); ?>
							<?php include LIFELINE_DONATION_PATH . 'templates/donation-modal/recurring_fields.php' ?>
							<div class="recuring-paypal" v-show="recurring" style="display: block;">
								<div class="offset-2 wpcm-col-md-8">
									<div class="textfieldd el-custom-select">
										<el-select v-model="billing_period" size="large">
											<el-option selected="selected" value=""><?php esc_html_e( 'Payment Cycle', 'lifeline-donation' ); ?></el-option>
											<el-option value="daily" label="<?php esc_html_e( 'Daily', 'lifeline-donation' ); ?>"></el-option>
											<el-option value="weekly" label="<?php esc_html_e( 'Payment Cycle', 'lifeline-donation' ); ?>"></el-option>
											<el-option value="fortnightly" label="<?php esc_html_e( 'Fortnightly', 'lifeline-donation' ); ?>"></el-option>
											<el-option value="monthly" label="<?php esc_html_e( 'Monthly', 'lifeline-donation' ); ?>"></el-option>
											<el-option value="quaterly" label="<?php esc_html_e( 'Quaterly', 'lifeline-donation' ); ?>"></el-option>
											<el-option value="half yearly" label="<?php esc_html_e( 'Half yearly', 'lifeline-donation' ); ?>"></el-option>
											<el-option value="yearly" label="<?php esc_html_e( 'Yearly', 'lifeline-donation' ); ?>"></el-option>
										</el-select>

									</div>
								</div>
							</div>
							<div class="donar-info">
								<h4>Personal Detail</h4>
								<form action="">
									<input type="text" placeholder="<?php esc_html_e( 'First Name', 'lifeline-donation' ); ?>" v-model="billing_fields.first_name" :disabled="loading" required>
									<input type="text" placeholder="<?php esc_html_e( 'Last Name', 'lifeline-donation' ); ?>" v-model="billing_fields.last_name" :disabled="loading" required>
									<input type="email" placeholder="<?php esc_html_e( 'Email Id', 'lifeline-donation' ); ?>" v-model="billing_fields.email" :disabled="loading" required>
									<input type="text" placeholder="<?php esc_html_e( 'Phone Number', 'lifeline-donation' ); ?>" v-model="billing_fields.phone" :disabled="loading">
									<textarea placeholder="<?php esc_html_e( 'Address', 'lifeline-donation' ); ?>" v-model="billing_fields.address" :disabled="loading"></textarea>
								</form>
							</div>
							<div class="donation-proces-btn">
								<button class="donation-done" type="button" @click.prevent="submit()">
									<?php esc_html_e( 'Donate Now', 'lifeline-donation' ); ?>
									<i class="fa fa-refresh fa-spin" v-if="loading"></i>
								</button>

								<button  @click.prevent="closePopup('2')" class="btn-back bk-step"><i class="fa fa-arrow-left"></i><?php esc_html_e( 'Go Back', 'lifeline-donation' ); ?></button>
							</div>

						</div>
					</div><!-- Popup Centralize -->
				</div>
			</div><!-- Donation Popup -->
		</div>

	
	</div>
</div>


<div class="lifeline-donation-modal wpcm-wrapper footer-donation-modal">
</div>
