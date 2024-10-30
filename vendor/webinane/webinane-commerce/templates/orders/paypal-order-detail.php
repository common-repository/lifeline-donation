<?php
/**
 * Paypal order detail.
 *
 * @package WordPress
 */

$transaction = get_post_meta( $order->ID, '_order_transaction_id', true );
$total = get_post_meta( $order->ID, '_order_total', true );
$fee = get_post_meta( $order->ID, '_order_fee', true );
$currency = get_post_meta( $order->ID, '_order_currency', true );
$order_data = WebinaneCommerce\Classes\Orders::order_data( $order );

$orders_label = apply_filters( 'wpcm_orders_admin_menu_label', esc_html__( 'Orders', 'lifeline-donation' ) );
$order_label = apply_filters( 'wpcm_order_admin_menu_label', esc_html__( 'Order', 'lifeline-donation' ) )
?>

<div class="wpcm-order-success-detail wpcm-wrapper alignfull">
	<h3>
		<?php
			// translators: The orders label.
			printf( esc_html__( '%s Detail', 'lifeline-donation' ), esc_html( $order_label ) );
		?>
	</h3>

	<table class="table">
		<tbody>
			<tr>
				<th><?php esc_html_e( 'Transaction ID', 'lifeline-donation' ); ?></th>
				<td><?php echo esc_attr( $transaction ); ?></td>
			</tr>
			<tr>
				<th><?php esc_html_e( 'Gateway', 'lifeline-donation' ); ?></th>
				<td><?php esc_html_e( 'PayPal', 'lifeline-donation' ); ?></td>
			</tr>
			<tr>
				<th><?php esc_html_e( 'Transaction Status', 'lifeline-donation' ); ?></th>
				<td><?php echo esc_attr( $order->display_status ); ?></td>
			</tr>
			<tr>
				<th>
					<?php
					// translators: Order label.
					printf( esc_html__( '%s Total', 'lifeline-donation' ), esc_attr( $order_label ) );
					?>
				</th>
				<td><?php echo wp_kses_post( $order->formatted_price ); ?></td>
			</tr>
			<tr>
				<th><?php esc_html_e( 'Transaction Fee', 'lifeline-donation' ); ?></th>
				<td><?php echo esc_attr( $fee ); ?></td>
			</tr>
			<tr>
				<th><?php esc_html_e( 'Currency', 'lifeline-donation' ); ?></th>
				<td><?php echo esc_attr( $currency ); ?></td>
			</tr>
			
		</tbody>
	</table>
	<?php if ( isset( $order_data->order_items ) ) : ?>
		<table class="table table-bordered">
			<thead>
				<tr>
					<th><?php esc_html_e( 'Item Name', 'lifeline-donation' ); ?></th>
					<th><?php esc_html_e( 'Price', 'lifeline-donation' ); ?></th>
					<th><?php esc_html_e( 'Quantity', 'lifeline-donation' ); ?></th>
					<th><?php esc_html_e( 'Total', 'lifeline-donation' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $order_data->order_items as $item ) : ?>
					<tr>
						<td><?php echo esc_attr( $item->order_item_name ); ?></td>
						<td><?php echo esc_attr( $item->price ); ?></td>
						<td><?php echo esc_attr( $item->qty ); ?></td>
						<td><?php echo wp_kses( webinane_cm_price_with_symbol( $item->qty * $item->price ), wp_kses_allowed_html( 'post' ) ); ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	<?php endif; ?>
</div>
