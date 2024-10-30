
	<div class="story donors-list">
		<div class="story-img">
			<?php echo get_avatar( $order->customer->email, 270) ?>
		</div>
		<div class="story-detail">

			<span><i class="fa fa-calendar"></i><?php echo date(get_option('date_format'), strtotime($order->post_date)) ?></span>
			<h3><?php echo get_the_title($order->ID) ?></h3>
			<div class="spent-bar">
				<span><?php esc_html_e('Donation', 'lifeline-donation') ?></span>
				<span class="price"><?php echo webinane_cm_price_with_symbol($order->total); ?></span>
			</div>
		</div>
	</div>
