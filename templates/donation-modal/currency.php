<?php $settings = wpcm_get_settings(); ?>


<div class="wpcm-row wpcm-justify-content-center">
	
	<?php do_action('webinane_commerce/popup/before_currencies') ?>
    
    <div class="wpcm-col-md-8 wpcm-col-md-offset-2" v-if="Object.keys(currencies).length">
		
		<?php if ( webinane_set($settings, 'enable_custom_dropdown') === true && webinane_set($settings, 'donation_custom_dropdown')) : ?>
			<div class="el-custom-select custom-drop" style="padding: 20px 0px;">
				<el-select v-model="extras.dropdown" size="large">
					<el-option v-for="(label) in dropdown" :key="label" :value="label" :label="label"></el-option>
				</el-select>
			</div>
		<?php endif; ?>

		<?php if( $settings->get('donation_multicurrency') ) : ?>
			<div class="el-custom-select">
				<el-select v-model="currency" size="large">
					<el-option v-for="(label, opt_key) in currencies" :key="opt_key" :value="opt_key" :label="label"></el-option>
				</el-select>
			</div>
		<?php endif; ?>
	</div>
	<?php if ( array_get( $settings, 'donation_predefined_amounts' ) ) : ?>
		<div class="wpcm-col-md-8 wpcm-col-md-offset-2">
			<div class="your-donation">
				<strong class="popup-title"><?php esc_html_e('How much would you like to donate?', 'lifeline-donation'); ?></strong>
				<ul class="donation-figures">
					<li v-for="amt in amount_slabs" v-if="amount_slabs">
						<a :class="{active: amount == amt, 'wpdonation-button': true}" @click.prevent="amount = amt" href="#" title="">
						{{amt}}</a>
					</li>
				</ul>
			</div>
		</div>
	<?php endif; ?>

	<?php if( array_get($settings, 'donation_custom_amount') ) : ?>
		<div class="wpcm-col-md-8 wpcm-col-md-offset-2">
			<div class="your-donation single-proced-btn">
				<div class="donation-amount">
					<div class="textfield">
						<textarea v-model="amount" placeholder="<?php esc_html_e('Enter The Amount You Want', 'lifeline-donation' ); ?>" onkeyup="this.value=this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')"></textarea>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>
	<div class="wpcm-col-md-8 wpcm-col-md-offset-2">
		<div class="your-donation single-proced-btn">
			<a class="proceed" href="#" title="" @click.prevent="currencyStep()"><?php esc_html_e('Proceed', 'lifeline-donation'); ?></a>
		</div>
	</div>
</div>
