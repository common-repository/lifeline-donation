<?php $html = wp_kses_allowed_html( 'post' ); ?>
<?php while( have_posts() ) : the_post(); ?>
	<div class="blog-detail-page">
		<div class="post-intro cause-intro">
			<div class="post-thumb">
				<?php if (class_exists('Webinane_Resizer')): ?>
					<?php echo wp_kses($img_obj->webinane_resize(wp_get_attachment_url(get_post_thumbnail_id(get_the_ID()), 'full'), 1170, 531, true), $html); ?>
				<?php else: ?>
					<?php the_post_thumbnail('full'); ?>
				<?php endif; ?>

			</div>
			<div class="wpcm-row">
				<div class="wpcm-col-md-9 wpcm-col-sm-8 wpcm-col-xs-8">
					<ul class="meta">
						<li content="<?php echo esc_attr(get_the_date(get_option('date_format', get_the_ID()))); ?>" itemprop="datePublished"><i class="ti-calendar"></i><?php echo esc_attr(get_the_date(get_option('date_format', get_the_ID()))); ?></li>
						<?php if (webinane_set($page_meta, 'location')) : ?>
							<li itemprop="location" itemscope itemtype="http://schema.org/Place"><span itemprop="address" itemscope itemtype="http://schema.org/PostalAddress"><i class="ti-location-pin"></i> <span itemprop="streetAddress"><?php echo esc_html(webinane_set($page_meta, 'location')); ?></span></span></li>
						<?php endif; ?>
						<li itemprop="author"><i class="fa fa-user"></i> <?php esc_html_e('By', 'lifeline-donation'); ?> 
							<a title="<?php echo ucwords(the_author_meta('display_name')); ?>" href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" itemprop="url">
								<?php echo ucwords(the_author_meta('display_name')); ?>
							</a>
						</li>
					</ul>
					<h1 class="post-title" itemprop="headline"><?php the_title(); ?></h1>
				</div>
				<div class="wpcm-col-md-3 wpcm-col-sm-4 wpcm-col-xs-4">
					<div class="cause-detail">
						<span><?php echo webinane_cm_price_with_symbol($donation_needed); ?></span>
						
							
							<?php
							if (wpcm_get_settings()->get('donation_Cpost_type') == 'donation_page_template'): ?>
								
								<strong class="d-amout-l">
									<?php esc_html_e('Needed Donation', 'lifeline-donation'); ?>
									<a itemprop="url" href="<?php echo esc_url(get_page_link(wpcm_get_settings()->get('donation_Cpost_select'))); ?>" >

										<?php esc_html_e('Donate Now', 'lifeline-donation') ?>

									</a>
								</strong>

							<?php elseif (wpcm_get_settings()->get('donation_template_type_general') == 'external_link'):

								$url = wpcm_get_settings()->get('donation_Cpost_linkGeneral'); ?>
								
								<strong class="d-amout-l">
									<?php esc_html_e('Needed Donation', 'lifeline-donation'); ?>
									<a itemprop="url" href="<?php echo esc_url($url) ?>" target="_blank" ><?php esc_html_e('Donate Now', 'lifeline-donation') ?></a>
								</strong>

							<?php else: ?>
								<donation-button :id="<?php the_ID(); ?>">
									<strong class="d-amout-l">
										<?php esc_html_e('Needed Donation', 'lifeline-donation'); ?>
										<a class="donation-modal-box-callerrrr" href="#"><?php esc_html_e('Donate Now', 'lifeline-donation') ?></a>
									</strong>
								</donation-button>
							<?php endif; ?>

						</strong>
					</div>

				</div>

			</div>
		</div>
		<?php the_content(); ?>
	</div>
<?php endwhile; wp_reset_postdata(); ?>