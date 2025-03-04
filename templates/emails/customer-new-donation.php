<?php 
	$new_order = wpcm_order($order);

	$items = $new_order->items(); 
	$item = $items->first();
	$meta = $new_order->meta->pluck('meta_value', 'meta_key');
	
	$customers = new \WebinaneCommerce\Classes\Customers($customer_id);
	$customer = $customers->customer;
	$orders_label = esc_html__('Donations', 'lifeline-donation');
	$order_label = esc_html__('Donation', 'lifeline-donation');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<style type="text/css">
		@import url('https://fonts.googleapis.com/css?family=Barlow:400,500,600,700&display=swap');

		@media only screen and (max-width:480px){
			.emailImage{
				height:auto !important;
				max-width:100% !important;
				width: 100% !important;
			}
			#emailContainer,
			#emailBody {
				width: 100% !important;
			}
			.bodyColumn {
				width: auto !important;
				display: block !important;
			}
		}
	</style> 
</head>
<body style="margin: 0; padding: 0; background-color: #ededed;">
	<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable" style="margin: 40px 0;">
		<tr>
			<td align="center" valign="top">
				<table border="0" cellpadding="0" cellspacing="0" width="535" id="emailContainer" style="box-shadow: 0 0 65px rgba(0, 0, 0, 0.08); border-radius: 12px;">
					<tr>
						<td align="center" valign="top">
							<table border="0" cellpadding="5" cellspacing="0" width="100%" id="emailHeader">
								<tr>
									<td align="center" valign="top">
										<img src="<?php echo wp_get_attachment_image_src( get_post_thumbnail_id( $item->post_id ), 'medium' )[0] ?>" alt="image" style="border-top-right-radius: 6px; border-top-left-radius: 6px;" class="emailImage" />
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td align="center" valign="top">
							<table border="0" cellpadding="35" cellspacing="0" width="100%" id="emailBody" bgcolor="#ffffff">
								<tr>
									<td align="left" valign="middle" width="55%" class="bodyColumn">
										<table border="0" cellpadding="0" cellspacing="0" width="100%">
											<tr>
												<td align="left" valign="top">
													<span style="font-family: 'Barlow', sans-serif; color: #8b8b8b; font-weight: 500; font-size: 15px;">Price:</span>
													<span style="font-family: 'Barlow', sans-serif; color: #1aa0e6; font-weight: 600; font-size: 20px;"><?php echo $new_order->formatted_price ?></span>
												</td>
											</tr>
											<tr>
												<td align="left" valign="top" width="100%" style="font-family: 'Barlow', sans-serif; color: #1a1a1a; font-weight: 600; font-size: 22px; padding-top: 15px; padding-bottom: 16px;">
													<?php echo get_the_title($item->post_id) ?>
												</td>
											</tr>
											<tr>
												<td align="left" valign="top" style="font-family: 'Barlow', sans-serif; color: #999999; font-size: 17px; line-height: 30px;">
													<?php echo esc_attr($customer->address) ?><br/> 
													<?php echo esc_attr($customer->city.' '.$customer->zip) ?><br/>
													<?php echo esc_attr($customer->state.' '.$customer->country) ?>
												</td>
											</tr>
										</table>
									</td>
									<td align="left" valign="top" width="40%" class="bodyColumn">
										<table cellpadding="0" cellspacing="0" width="100%">
											<tr>
												<td align="left" valign="top">
													<table cellspacing="" cellpadding="22" width="100%" style="border: 3px solid #ededed; border-radius: 4px;" bgcolor="#ffffff">
														<tr>
															<td align="left" valign="top">
																<table cellpadding="8" border="0" cellspacing="0" width="100%">
																	<tr>
																		<td align="left" valign="top" style="font-family: 'Barlow', sans-serif; color: #666666; font-size: 15px;">
																			<?php esc_html_e('Quantity', 'lifeline-donation'); ?>:  
																		</td>
																		<td align="right" valign="top" style="font-family: 'Barlow', sans-serif; color: #666666; font-size: 15px;">
																			<?php echo esc_attr($new_order->all_qty) ?>
																		</td>
																	</tr>
																</table>
																<table cellspacing="8" boder="0" cellpadding="0" width="100%" style="border-top: 1px solid #ededed; margin-top: 14px; padding-top: 10px;">
																	<tr>
																		<td align="left" valign="top" style="font-family: 'Barlow', sans-serif; color: #1aa0e6; font-size: 15px; font-weight: 600;">
																			<?php esc_html_e('Total', 'lifeline-donation'); ?>: 
																		</td>
																		<td align="right" valign="top" style="font-family: 'Barlow', sans-serif; color: #1aa0e6; font-size: 15px; font-weight: 600;">
																			<?php echo wp_kses_post($new_order->formatted_price) ?>
																		</td>
																	</tr>
																</table>
															</td>
														</tr>
													</table>
													<table cellspacing="0" cellpadding="0" width="100%" style="background-color: #1aa0e6; border-radius: 3px; margin-top: 12px;">
														<tr>
															<td align="center" valign="middle" style="color:#FFFFFF; font-family: 'Barlow', sans-serif; font-size:14px; font-weight:bold; line-height:150%; padding-top:17px; padding-right:40px; padding-bottom:17px; padding-left:40px;">
																<a href="<?php echo esc_url($new_order->profile_url); ?>" target="_blank" style="color:#FFFFFF; text-decoration:none;"><?php printf(esc_html__('VIEW %s', 'lifeline-donation'), $orders_label ); ?></a>
															</td>
														</tr>
													</table>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td align="left" valign="top">
							<table border="0" cellpadding="0" cellspacing="0" width="100%" id="emailFooter" bgcolor="#f4f4f4" style="border-bottom-right-radius: 12px; border-bottom-left-radius: 12px;">
								<tr>
									<td align="top" valign="middle" width="75%">
										<table border="0" cellpadding="40" cellspacing="0" width="100%">
											<tr>
												<td align="left" valign="top">
													<span style="color: #1b5e82; font-size: 15px; font-family: 'Barlow', sans-serif;"><?php printf(esc_html__('Hi, %s', 'lifeline-donation'), $customer->name) ?></span>
													<br/>
													<span style="color: #1aa0e6; font-size: 20px; font-family: 'Barlow', sans-serif; font-weight: 700; padding-top: 5px; display: block;"><?php printf( esc_html__('Thank you for the %s', 'lifeline-donation'), $order_label ); ?></span>
												</td>
											</tr>
										</table>
									</td>
									<td align="right" valign="middle" width="25%">
										<table border="0" cellpadding="30" cellspacing="20" width="100%">
											<tr>
												<td align="center" valign="middle" bgcolor="#ffffff">
													<?php the_custom_logo() ?>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</body>
</html>