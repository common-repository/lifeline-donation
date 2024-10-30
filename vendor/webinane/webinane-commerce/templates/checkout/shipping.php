<front-shipping-address>
	<div class="wpcm-checkout-biling" v-show="ship_diff">
		<h4 class="wpcm-order-detail-header"><?php esc_html_e('Shipping Address', 'lifeline-donation' ) ?></h4>
		<div class="wpcm-checkout-biling-form">
			<form action="">
				<div class="wpcm-checkout-biling-group wpcm-name-field">
					<label><?php esc_html_e( 'Complete Name', 'lifeline-donation' ) ?></label>
					<input type="text" class="wpcm-form-input" v-model="shipping_fields.first_name"  placeholder="<?php esc_html_e( 'First Name', 'lifeline-donation' ); ?>">
					<input type="text" class="wpcm-form-input" v-model="shipping_fields.last_name" placeholder="<?php esc_html_e( 'Last Name', 'lifeline-donation' ); ?>">
				</div>
				<div class="wpcm-checkout-biling-group">
					<label><?php esc_html_e( 'Company Name', 'lifeline-donation' ) ?></label>
					<input type="text" name="" class="wpcm-form-input" v-model="shipping_fields.company">
				</div>
				<div class="wpcm-checkout-biling-group">
					<label><?php esc_html_e( 'Country', 'lifeline-donation' ) ?></label>
					<div class="wpcm-custom-select">
						<select class="wpcm-form-input" v-model="shipping_fields.base_country">
							<option v-for="(country, country_id) in countries" :value="country_id">{{ country }}</option>
						</select>
					</div>
				</div>
				<div class="wpcm-checkout-biling-group">
					<label><?php esc_html_e( 'Street Address', 'lifeline-donation' ); ?></label>
					<input type="text"class="wpcm-form-input" placeholder="<?php esc_html_e( 'House Number and Street Name', 'lifeline-donation' ); ?>" v-model="shipping_fields.address_line_1">
					<input type="text" class="wpcm-form-input" placeholder="<?php esc_html_e( 'Apartment, suits, unit etc. (options)', 'lifeline-donation' ); ?>" v-model="shipping_fields.address_line_2">
				</div>
				<div class="wpcm-checkout-biling-group">
					<label><?php esc_html_e( 'Town and City', 'lifeline-donation' ) ?></label>
					<input type="text" class="wpcm-form-input" placeholder="<?php esc_html_e( 'House Number and Street Name', 'lifeline-donation' ); ?>" v-model="shipping_fields.city">
				</div>
				<div class="wpcm-checkout-biling-group">
					<label><?php esc_html_e( 'State / Country', 'lifeline-donation' ) ?></label>
					<input type="text" class="wpcm-form-input" placeholder="<?php esc_html_e( 'State / Country', 'lifeline-donation' ); ?>" v-model="shipping_fields.state">
				</div>
				<div class="wpcm-checkout-biling-group">
					<label><?php esc_html_e( 'Postcode / Zip', 'lifeline-donation' ) ?></label>
					<input type="text" class="wpcm-form-input" v-model="shipping_fields.zip">
				</div>
				<div class="wpcm-checkout-biling-group">
					<label><?php esc_html_e( 'Phone No', 'lifeline-donation' ) ?></label>
					<input type="text" class="wpcm-form-input" v-model="shipping_fields.phone">
				</div>
			</form>
		</div>	
	</div>

</front-shipping-address>