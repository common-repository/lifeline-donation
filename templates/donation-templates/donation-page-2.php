<?php
$id = ( $id ) ? $id : 0;
$html = wp_kses_allowed_html( 'post' );
$user = wp_get_current_user();
$settings = wpcm_get_settings();
?>
<div class="donation-box-wrapper wpcm-wrapper lifeline-donation-page post-detail-page donation-modal2 page2" :pid="<?php echo esc_attr( $id ); ?>">
	
	<div class="donation-box-wrapper">
		<div class="wpcm-row">

			<div class="wpcm-col-md-5 wpcm-col-sm-5 wpcm-col-xs-12">

				<div class="donation-box-wraper-inner">
					<?php if ( $title ) : ?>
					<div class="donation-box-title">

						<span><img src="<?php echo LIFELINE_DONATION_URL; ?>/assets/images/new-img.png" alt=""></span>

						<?php if( $title ) : ?>
							<h2><?php echo esc_attr($title) ?></h2>
						<?php else : ?>
							<h2 v-if="title">{{ title }}</h2>
						<?php endif; ?>
					</div>
					<?php endif; ?>
					<div class="donation-amount-box">
						<el-select v-model="currency" @change="getCurrencySymbol($event)" size="large">
							<el-option v-for="(label, opt_key) in currencies" :key="opt_key" :value="opt_key" :label="label"></el-option>
						</el-select>
						
						<div class="custom-donation-amount">
							<span>{{symbol}}</span>
							<input v-model="amount" type="text" placeholder="Enter CUstom Amount">
						</div>

						<ul class="list-unstyled">
							<li v-for="amt in amount_slabs" v-if="amount_slabs">
								<a :class="{active: amount == amt, 'wpdonation-button': true}" @click.prevent="amount = amt" href="#" title="">
								{{symbol}}{{amt}}</a>
							</li>
						</ul>
					</div>

					<?php do_action( 'webinane_commerce/popup/before_currencies' ); ?>

					<a href="#" title="" @click.prevent="(amount ) ? (showModalBox2 = true) : $notify.error({title: 'Error', message: 'Please enter the amount', offset: 35})" class="donation-done"><?php esc_html_e( 'Donate Now', 'lifeline-donation' ); ?></a>

				</div>
			</div>
			<div class="wpcm-col-md-7 wpcm-col-sm-7 wpcm-col-xs-12">
				<?php echo wp_kses( $content, $html ); ?>
			</div>

		</div>
		<div class="wpcm-wrapper footer-donation-modal popup-style2">
			<div class="donation-modal-box" v-show="showModalBox2" style="display: none;">
				<div class="donation-popup" style="display: block;">
				<div class="wpcm-container">
					<span class="closep" @click.prevent="closePopup('2')"><i class="fa fa-remove"></i></span>
					<div class="donation-box-wraper-inner">
							<?php if ( $title ) : ?>
						<div class="donation-box-title">
							<img src="<?php echo LIFELINE_DONATION_URL; ?>/assets/images/new-img.png" alt="">
							<h2><?php echo esc_html( $title ); ?></h2>
						</div>
					<?php endif; ?>
						<div class="donation-payment-cycle">
							<a href="#" @click.prevent="step = 1;recurring = true" :class="(recurring) ? 'active' : ''"><?php esc_html_e( 'Recurring', 'lifeline-donation' ); ?></a>
							<a href="#" @click.prevent="step = 1;recurring = false" :class="(!recurring) ? 'active' : ''"><?php esc_html_e( 'One Time', 'lifeline-donation' ); ?></a>
						</div>
						<?php include LIFELINE_DONATION_PATH . 'templates/donation-modal/recurring_fields.php'; ?>

						<?php if ( webinane_set( $settings, 'enable_custom_dropdown' ) === true && webinane_set( $settings, 'donation_custom_dropdown' ) ) : ?>
							 <div class="el-custom-select custom-drop" style="    padding: 15px 0px;">
								<el-select v-model="extras.dropdown" size="large">
									<el-option v-for="(label) in dropdown" :key="label" :value="label" :label="label"></el-option>
								</el-select>
							</div>
						<?php endif; ?>

						<div class="donation-payment-method">
							<div v-if="gateways" v-for="(gateway, gateway_id) in gateways">
								<a @click.prevent="payment_method = gateway.id" :class="getwayActiveClass(gateway.id)" title="" href="#" v-if="(recurring && gateway.recurring) || !recurring">
									<img v-if="gateway.icon" :src="gateway.icon" :alt="gateway.name" />
									{{ (gateway.title) ? gateway.title : gateway.name }}
								</a>
							</div>
						</div>
						<?php do_action( 'webinane_checkout_payment_gateway_data' ); ?>
						<div class="recuring-paypal" v-show="recurring" style="display: block;">
							<div class="wpcm-col-md-offset-3 wpcm-col-md-6">
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
							<h4><?php esc_html_e( 'Personal Detail', 'lifeline-donation' ); ?></h4>
							<form action="">
								<input type="text" placeholder="<?php esc_html_e( 'First Name', 'lifeline-donation' ); ?>" v-model="billing_fields.first_name" :disabled="loading" required>
								<input type="text" placeholder="<?php esc_html_e( 'Last Name', 'lifeline-donation' ); ?>" v-model="billing_fields.last_name" :disabled="loading" required>
								<?php if ( is_user_logged_in() ) : ?>
									<input disabled :run="billing_fields.email = '<?php echo sanitize_email($user->data->user_email) ?>'" value="<?php echo sanitize_email($user->data->user_email) ?>" type="email" placeholder="<?php esc_html_e( 'Email Id', 'lifeline-donation' ); ?>" required>
								<?php else : ?>
									<input type="email" placeholder="<?php esc_html_e( 'Email Id', 'lifeline-donation' ); ?>" v-model="billing_fields.email" :disabled="loading" required>
								<?php endif; ?>
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
			</div>
		</div>
	</div>
</div>

