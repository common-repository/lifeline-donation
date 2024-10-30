<?php $settings = wpcm_get_settings(); ?>

<div>
	<div class="lifeline-donation-modal donation-modal2 wpcm-wrapper footer-donation-modal">
		<div class="donation-modal-box" v-if="showModalBox">        
			<div class="donation-popup" :style="(showModalBox)? 'display: block;' : ''">
				<div class="wpcm-container">
					<span class="closep" @click.prevent="closePopup()"><i class="fa fa-remove"></i></span>
					<div class="clearfix" v-show="step == 1">

						<div class="donation-box-title">
							<div class="d-block">
								<input type="hidden" maxlength="3" placeholder="<?php esc_html_e('CVV', 'lifeline-donation') ?>" v-model="ccard.code" class="wpcm-form-input form-control">
								<img src="<?php echo LIFELINE_DONATION_URL?>/assets/images/new-img.png" alt="">
							</div>
							<h2 v-if="title" v-html="title"></h2>
							<p v-if="text" v-html="text"></p>
						</div>
						<div class="donation-amount-box">
							
							<?php if ($settings->get('donation_recurring_payments') === true) : ?>
								<div class="donation-payment-cycle">
									<a href="#" @click.prevent="step = 1;recurring = true" :class="(recurring) ? 'active' : ''"><?php esc_html_e('Recurring', 'lifeline-donation'); ?></a>
									<a href="#" @click.prevent="step = 1;recurring = false" :class="(!recurring) ? 'active' : ''"><?php esc_html_e('One Time', 'lifeline-donation'); ?></a>
								</div>
							<?php endif; ?>
	
							<?php include LIFELINE_DONATION_PATH . 'templates/donation-modal/recurring_fields.php' ?>

							<?php if ( webinane_set($settings, 'enable_custom_dropdown') === true && webinane_set($settings, 'donation_custom_dropdown')) : ?>
								<div class="el-custom-select custom-drop" style="padding: 20px 0px">
									<el-select v-model="extras.dropdown" size="large">
										<el-option v-for="(label) in dropdown" :key="label" :value="label" :label="label"></el-option>
									</el-select>
								</div>
							<?php endif; ?>

							<div class="donation-payment-method">
								<div v-if="gateways" v-for="(gateway, gateway_id) in gateways">
									<a @click.prevent="payment_method = gateway.id" :class="getwayActiveClass(gateway.id)" title="" href="#" v-if="(recurring && gateway.recurring) || !recurring">{{ (gateway.title) ? gateway.title : gateway.name }}</a>
								</div>
							</div>
						
							<?php do_action('webinane_checkout_payment_gateway_data') ?>
							<div class="recuring-paypal mt-5" v-show="recurring" style="display: block;">
								<div class="wpcm-col-md-12" style="padding: 0;">
									<div class="textfieldd el-custom-select">
										<el-select v-model="billing_period" size="large">
											<el-option selected="selected" value=""><?php esc_html_e('Payment Cycle', 'lifeline-donation') ?></el-option>
											<el-option value="daily" label="<?php esc_html_e('Daily', 'lifeline-donation') ?>"></el-option>
											<el-option value="weekly" label="<?php esc_html_e('Payment Cycle', 'lifeline-donation') ?>"></el-option>
											<el-option value="fortnightly" label="<?php esc_html_e('Fortnightly', 'lifeline-donation') ?>"></el-option>
											<el-option value="monthly" label="<?php esc_html_e('Monthly', 'lifeline-donation') ?>"></el-option>
											<el-option value="quaterly" label="<?php esc_html_e('Quaterly', 'lifeline-donation') ?>"></el-option>
											<el-option value="half yearly" label="<?php esc_html_e('Half yearly', 'lifeline-donation') ?>"></el-option>
											<el-option value="yearly" label="<?php esc_html_e('Yearly', 'lifeline-donation') ?>"></el-option>
										</el-select>

									</div>
								</div>	
							</div>

							<?php if( $settings->get('donation_multicurrency') ) : ?>
								<el-select v-model="currency" @change="getCurrencySymbol($event)" size="large" style="width: 100%; margin-top: 20px;">
									<el-option v-for="(label, opt_key) in currencies" :key="opt_key" :value="opt_key" :label="label"></el-option>
								</el-select>
							<?php endif; ?>

							<div class="custom-donation-amount wpcm-d-flex mt-5">
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
						<div class="donation-box-wraper-inner">

							<div class="your-donation single-proced-btn">
								<a class="proceed" href="#" title="" @click.prevent="currencyStep()"><?php esc_html_e('Proceed', 'lifeline-donation'); ?></a>
							</div>
							<div class="paragraph_default"></div>
							<div id="step1-error1"></div>

						</div>
					</div>
					<div class="step2"  v-show="step == 2">
						<div class="donar-info">
							<h4>Personal Detail</h4>
							<form action="">
								<input type="text" placeholder="<?php esc_html_e('First Name', 'lifeline-donation') ?>" v-model="billing_fields.first_name" :disabled="loading" required>
								<input type="text" placeholder="<?php esc_html_e('Last Name', 'lifeline-donation') ?>" v-model="billing_fields.last_name" :disabled="loading" required>
								<input type="email" placeholder="<?php esc_html_e('Email Id', 'lifeline-donation') ?>" v-model="billing_fields.email" :disabled="loading" required>
								<input type="text" placeholder="<?php esc_html_e('Phone Number', 'lifeline-donation') ?>" v-model="billing_fields.phone" :disabled="loading">
								<textarea placeholder="<?php esc_html_e('Address', 'lifeline-donation') ?>" v-model="billing_fields.address_line_1" :disabled="loading"></textarea>
							</form>
						</div>

						<div class="donation-proces-btn wpcm-d-flex" >
							<button class="donation-done" type="button" @click.prevent="submit()">
								<?php esc_html_e('Donate Now', 'lifeline-donation') ?>
								<i class="fa fa-refresh fa-spin" v-if="loading"></i>
							</button>

							<button  @click.prevent="step = 1" class="donation-done"><i class="fa fa-arrow-left"></i> <?php esc_html_e('Go Back', 'lifeline-donation'); ?></button>

						</div>
					</div>
				</div><!-- Popup Centralize -->
			</div>
		</div><!-- Donation Popup -->
	</div>
</div>