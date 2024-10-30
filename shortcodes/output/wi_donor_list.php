<?php
use WebinaneCommerce\Models\Order;

wp_enqueue_style('webinane-shortcodes');
$user_id = isset($_GET['wpcm_u']) ? absint(sanitize_text_field( $_GET['wpcm_u'] )) : false;

if($user_id){

	$orders = Order::whereHas('meta', function($query) use ($user_id) {
		$query->where(['meta_key' => '_wpcm_order_customer_id', 'meta_value' => $user_id]);
	})->status('completed')->paginate(12);

} else {
	$orders = Order::status('completed')->paginate(12);
}

if($orders) : ?>

	<div class="wpcm-wrapper">
		<div class="wpcm-container">
			<div class="wpcm-row masonary">
				<?php foreach ($orders as $order) : ?>
					<div class="wpcm-col-md-3 wpcm-col-sm-6 wpcm-col-xs-6">
						<?php include LIFELINE_DONATION_PATH . 'shortcodes/output/partials/donors.php' ?>
					</div>
				<?php endforeach; ?>
			</div>
		</div>

		<?php webinane_donation_template_load('pagination.php', array('paginator' => $orders, 'elements' => $orders->elements() )) ?>
	</div>

<?php endif; ?>

