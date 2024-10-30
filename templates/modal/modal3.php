<?php $settings = wpcm_get_settings(); ?>

<div>
	<div class="lifeline-donation-modal popup-style3 wpcm-wrapper footer-donation-modal">
		<div class="donation-modal-box" v-if="showModalBox">        
			<div class="donation-popup donation-box-wraper-inner" :style="(showModalBox)? 'display: block;' : ''">
				<div class="wpcm-container">
					<span class="closep" @click.prevent="closePopup()"><i class="fa fa-remove"></i></span>
					<?php if( wpcm_get_settings()->get('donation_calculation_bar') == 'true' ): ?>
						<div class="donation-amount-bar">
							<div class="amount-info-box">
								<h2 v-if="needed_amt"><span>{{symbol}}</span>{{needed_amt.amt}}</h2>
								<span><?php esc_html_e('Needed', 'lifeline-donation'); ?></span>
							</div>
							<div class="amount-info-box">
								<h2 v-if="collected_amt"><span>{{symbol}}</span>{{collected_amt.amt}}</h2>
								<span><?php esc_html_e('Collected', 'lifeline-donation'); ?></span>
							</div>
						</div>
					<?php endif; ?>
					<div class="donation-box-title">
						<span v-if="title" v-html="title"></span>
						<h2 v-if="text" v-html="text"></h2>
					</div>

					<?php if ( $settings->get('donation_recurring_payments') === true ) : ?>
						<div class="donation-payment-cycle" style="margin-bottom:20px" >
							<a :class="(recurring) ? 'active' : ''" @click.prevent="step = 1;recurring = true" href="#"><?php esc_html_e('Recurring', 'lifeline-donation'); ?></a>
							<a :class="(!recurring) ? 'active' : ''" @click.prevent="step = 1;recurring = false" href="#" title=""><?php esc_html_e('One Time', 'lifeline-donation'); ?></a>
						</div>
					<?php endif; ?>

					<?php include LIFELINE_DONATION_PATH . 'templates/donation-modal/recurring_fields.php' ?>

					 <?php if ( webinane_set($settings, 'enable_custom_dropdown') === true && webinane_set($settings, 'donation_custom_dropdown')) : ?>
						 <div class="el-custom-select donation-amount-currency">
							<el-select v-model="extras.dropdown" size="large">
								<el-option v-for="(label) in dropdown" :key="label" :value="label" :label="label"></el-option>
							</el-select>
						</div>
					<?php endif; ?>

					<?php if( $settings->get('donation_multicurrency') ) : ?>
						<div class="donation-amount-currency" v-if="Object.keys(currencies).length">
							<el-select v-model="currency" @change="getCurrencySymbol($event)" size="large" style="width:100%">
								<el-option v-for="(label, opt_key) in currencies" :key="opt_key" :value="opt_key" :label="label"></el-option>
							</el-select>
						</div>
					<?php endif; ?>

					<div class="clearfix" v-show="step == 1">
						<div class="donation-amount-box">
							<h4>
								<?php esc_html_e('How much would you like to donate?', 'lifeline-donation'); ?>
							</h4>
							<div class="custom-donation-amount">
								<span>{{symbol}}</span>
								<input type="text" v-model="amount">
							</div>
							<div class="donation-amount-list">
								<ul class="list-unstyled">
									<li v-for="amt in amount_slabs" v-if="amount_slabs">
										<a :class="{active: amount == amt, 'wpdonation-button': true}" @click.prevent="amount = amt" href="#" title="">
										{{amt}}</a>
									</li>
								</ul>
							</div>
						</div>
						<a href="#" title="" @click.prevent="currencyStep()" class="donation-done mb-5"><?php esc_html_e('Donate Now', 'lifeline-donation'); ?></a>
					</div>
					<div class="step2"  v-show="step == 2">
						<div class="donation-payment-method">
							<a v-for="gatewy in gateways" :class="(payment_method == gatewy.id) ? 'active' : ''" href="#" title="" @click.prevent="payment_method = gatewy.id" v-if="(recurring && gatewy.recurring) || !recurring">
								<span v-if="gatewy.icon"><img :src="gatewy.icon" alt=""></span>
								{{ (gatewy.title) ? gatewy.title : gatewy.name }}
							</a>
						</div>
						<div class="recuring-payments wpcm-row mb-5" v-show="recurring" style="display: block;">
				    		<div class="wpcm-col-md-6">
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
				    	<?php do_action('webinane_checkout_payment_gateway_data') ?>
						<div class="donar-info">
							<h4><?php esc_html_e('Personal Detail', 'lifeline-donation'); ?></h4>
							<div class="row">
								<div class="col-lg-6">
									<input type="text" v-model="billing_fields.first_name" placeholder="<?php esc_attr_e('First Name', 'lifeline-donation'); ?>">
								</div>
								<div class="col-lg-6">
									<input type="text" v-model="billing_fields.last_name" placeholder="<?php esc_attr_e('Last Name', 'lifeline-donation'); ?>">
								</div>
								<div class="col-lg-6">
									<input type="text" v-model="billing_fields.email" placeholder="<?php esc_attr_e('Email Address', 'lifeline-donation'); ?>">
								</div>
								<div class="col-lg-6">
									<input type="tel" v-model="billing_fields.phone" placeholder="<?php esc_attr_e('Phone No', 'lifeline-donation'); ?>">
								</div>
							</div>
							<textarea v-model="billing_fields.address_line_1" placeholder="<?php esc_attr_e('Address', 'lifeline-donation'); ?>"></textarea>
						</div>
						<div id="step2-error1"></div>
						<div class="donation-proces-btn mb-5" >
							<button class="donation-done" type="button" @click.prevent="submit()">
								<?php esc_html_e('Donate Now', 'lifeline-donation') ?>
								<i class="fa fa-refresh fa-spin" v-if="loading"></i>
							</button>

							<button  @click.prevent="step = 1" class="btn-back bk-step">
								<?php esc_html_e('Go Back', 'lifeline-donation'); ?>
							</button>

						</div>
					</div>
				</div><!-- Popup Centralize -->
			</div>
		</div><!-- Donation Popup -->
	</div>
</div>