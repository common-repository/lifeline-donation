<?php $user = wp_get_current_user(); ?>
<button @click.prevent="step = 1" class="btn-back"><?php esc_html_e('Go Back', 'lifeline-donation'); ?></button>
	<div class="wpcm-row wpcm-justify-content-center">
	    <div class="wpcm-col-md-8 wpcm-col-md-offset-2">
    		<div class="your-donation">
    			<strong class="popup-title"><?php esc_html_e('Select your payment option', 'lifeline-donation'); ?></strong>
    			<ul class="donation-figures">
    				<li v-if="gateways" v-for="(gateway, gateway_id) in gateways">
    					<a @click.prevent="payment_method = gateway.id" :class="getwayActiveClass(gateway.id)" title="" href="#">{{ (gateway.title) ? gateway.title : gateway.name }}</a>
    				</li>
    
    			</ul>
    		</div>
    	</div>
	</div>
	
	<?php do_action('webinane_checkout_payment_gateway_data') ?>

<div class="wpcm-row wpcm-justify-content-center">
    <div class="wpcm-col-md-8 wpcm-col-sm-12 wpcm-col-lg-8">

        <?php include LIFELINE_DONATION_PATH . 'templates/donation-modal/recurring_fields.php' ?>

    	<div class="recuring-paypal" v-show="recurring" style="display: block;">
    		<div class="offset-2 wpcm-col-md-8">
    			<div class="textfieldd el-custom-select">

    
                    <el-select v-model="billing_period" size="large">
    					<el-option selected="selected" value=""><?php esc_html_e('Payment Cycle', 'lifeline-donation') ?></el-option>
    					<el-option value="daily" label="<?php esc_html_e('Daily', 'lifeline-donation') ?>"></el-option>
                        <el-option value="weekly" label="<?php esc_html_e('Every Week', 'lifeline-donation') ?>"></el-option>
    					<el-option value="fortnightly" label="<?php esc_html_e('Every 2 Weeks', 'lifeline-donation') ?>"></el-option>
    					<el-option value="monthly" label="<?php esc_html_e('Every month', 'lifeline-donation') ?>"></el-option>
    					<el-option value="quarterly" label="<?php esc_html_e('Quarterly', 'lifeline-donation') ?>"></el-option>
                        <el-option value="yearly" label="<?php esc_html_e('Yearly', 'lifeline-donation') ?>"></el-option>
    					
    				</el-select>
    			</div>
    		</div>
    	</div>
    </div>
    <div class="wpcm-col-md-12 wpcm-col-sm-12 wpcm-col-lg-12">
    	<div class="wpdonation-box">
    		<h2 class="wpdonation-title"><?php esc_html_e('Personal Detail', 'lifeline-donation') ?></h2>
    		        
    		<div class="form easy-donation-box">
                <div class="single-credit-cardd">
        			<div class="wpcm-row wpmc-justify-content-center">
        			    <div class="wpcm-col-md-6">
            				<div class="textfield">
            					<input type="text" placeholder="<?php esc_html_e('First Name', 'lifeline-donation') ?>" v-model="billing_fields.first_name" :disabled="loading" required>
            				</div>
            			</div>
            			<div class="wpcm-col-md-6">
            				<div class="textfield">
            					<input type="text" placeholder="<?php esc_html_e('Last Name', 'lifeline-donation') ?>" v-model="billing_fields.last_name" :disabled="loading" required>
            				</div>
            			</div>
            			<div class="wpcm-col-md-6">
            				<div class="textfield">
                                <?php if(is_user_logged_in()) : ?>
            					   <input type="email" placeholder="<?php esc_html_e('Email Id', 'lifeline-donation') ?>" disabled required :run="billing_fields.email = '<?php echo $user->user_email  ?>'" value="<?php echo $user->user_email ?>">
                                <?php else : ?>
                                   <input type="email" placeholder="<?php esc_html_e('Email Id', 'lifeline-donation') ?>" v-model="billing_fields.email" :disabled="loading" required>
                                <?php endif; ?>
            				</div>
            			</div>
            			<div class="wpcm-col-md-6">
            				<div class="textfield">
            					<input type="tel" placeholder="<?php esc_html_e('Phone Number', 'lifeline-donation') ?>" v-model="billing_fields.phone" :disabled="loading" onkeyup="this.value=this.value.replace(/[^\d]/,'')">
            				</div>
            			</div>
            			<div class="wpcm-col-md-12">
            				<div class="textfield">
            					<textarea placeholder="<?php esc_html_e('Address', 'lifeline-donation') ?>" v-model="billing_fields.address_line_1" :disabled="loading"></textarea>
            				</div>
            			</div>
        			</div>
                </div>
    		</div>
    		<button class="theme-btn" type="button" @click.prevent="submit()">
    			<?php esc_html_e('Donate Now', 'lifeline-donation') ?>
    			<i class="fa fa-refresh fa-spin" v-if="loading"></i>
    		</button>
    	</div>
    </div>
</div>