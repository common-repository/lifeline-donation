<front-billing-address>
	<div class="wpcm-checkout-biling">
		<h4 class="wpcm-order-detail-header"><?php esc_html_e('Billing Details', 'lifeline-donation' ); ?></h4>
		<div class="wpcm-checkout-biling-form">
			<form action="">
				<div class="wpcm-checkout-biling-group wpcm-name-field">
					<label><?php esc_html_e('Complete Name', 'lifeline-donation' ); ?></label>
					<input type="text" class="wpcm-form-input" v-model="billing_fields.first_name"  placeholder="<?php esc_html_e( 'First Name', 'lifeline-donation' ); ?>">
					<input type="text" class="wpcm-form-input" v-model="billing_fields.last_name" placeholder="<?php esc_html_e( 'Last Name', 'lifeline-donation' ); ?>">
				</div>
				<div class="wpcm-checkout-biling-group">
					<label><?php esc_html_e('Company Name', 'lifeline-donation' ); ?></label>
					<input type="text" class="wpcm-form-input" v-model="billing_fields.company" placeholder="<?php esc_html__('Company Name', 'lifeline-donation') ?>">
				</div>
				<div class="wpcm-checkout-biling-group">
					<label><?php esc_html_e('Country', 'lifeline-donation' ); ?></label>
					<div class="wpcm-custom-select">
						<select class="wpcm-form-input" v-model="billing_fields.base_country">
							<option v-for="(country, country_id) in countries" :value="country_id">{{ country }}</option>
						</select>
					</div>
				</div>
				<div class="wpcm-checkout-biling-group">
					<label><?php esc_html_e('Street Address', 'lifeline-donation' ); ?></label>
					<input type="text"class="wpcm-form-input" placeholder="<?php esc_html_e( 'House Number and Street Name', 'lifeline-donation' ); ?>" v-model="billing_fields.address_line_1">
					<input type="text" class="wpcm-form-input" placeholder="<?php esc_html_e( 'Apartment, suits, unit etc. (options)', 'lifeline-donation' ); ?>" v-model="billing_fields.address_line_2">
				</div>
				<div class="wpcm-checkout-biling-group">
					<label><?php esc_html_e('Town and City', 'lifeline-donation' ); ?></label>
					<input type="text" class="wpcm-form-input" placeholder="<?php esc_html_e( 'House Number and Street Name', 'lifeline-donation' ); ?>" v-model="billing_fields.city">
				</div>
				<div class="wpcm-checkout-biling-group">
					<label><?php esc_html_e('State / County', 'lifeline-donation' ); ?></label>
					<input type="text" class="wpcm-form-input" placeholder="<?php esc_html_e( 'House Number and Street Name', 'lifeline-donation' ); ?>" v-model="billing_fields.state">
				</div>
				<div class="wpcm-checkout-biling-group">
					<label><?php esc_html_e('Postcode / Zip', 'lifeline-donation' ); ?></label>
					<input type="text" class="wpcm-form-input" v-model="billing_fields.zip">
				</div>
				<div class="wpcm-checkout-biling-group">
					<label><?php esc_html_e('Phone No', 'lifeline-donation' ); ?></label>
					<input type="text" class="wpcm-form-input" v-model="billing_fields.phone" placeholder="<?php esc_attr__('Phone Number', 'lifeline-donation') ?>">
				</div>
				<div class="wpcm-checkout-biling-group">
					<label><?php esc_html_e('Email Address', 'lifeline-donation' ); ?></label>
					<input type="text" class="wpcm-form-input" v-model="billing_fields.email" placeholder="<?php esc_attr__('Email', 'lifeline-donation'); ?>">
				</div>
			</form>
		</div>	
	</div>
	<div class="wpcm-ship-diff">
		<label class="wpcm-custom-checkbox">
		  	<input type="checkbox" v-model="ship_diff">
		  	<span class="wpcm-checkmark"></span>
		</label>
		<span><?php esc_html_e('Ship to a Diffrent Address?', 'lifeline-donation' ); ?></span>
	</div>

</front-billing-address>