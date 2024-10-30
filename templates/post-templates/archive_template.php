<?php $html = wp_kses_allowed_html( 'post' ); ?>
<div class="post-listview">
    <div class="wpcm-row wpcm-align-items-center">

	<?php if ( has_post_thumbnail() ) : ?>

		<div class="wpcm-col-md-6">

			<div class="post-img">

				<?php if (class_exists('Webinane_Resizer')): ?>

					<?php echo wp_kses($img_obj->webinane_resize(wp_get_attachment_url(get_post_thumbnail_id(get_the_ID()), 'full'), 800, 519, true), $html); ?>

				<?php else: ?>

					<?php the_post_thumbnail('full'); ?>

				<?php endif; ?>

				<span content="<?php echo esc_attr( get_the_date( get_option( 'date_format', get_the_ID() ) ) ); ?>" itemprop="datePublished">

					<i class="fa fa-calendar-o"></i><span><?php echo get_the_date( get_option( 'date_format', get_the_ID() ) ); ?></span>
				</span>


			</div><!-- Post Image -->

		</div>

	<?php endif; ?>

	<div class="<?php echo (has_post_thumbnail()) ? 'wpcm-col-md-6' : 'wpcm-col-md-12'; ?>">

		<div class="post-detail">

			<h3 itemprop="headline">

				<a  href="<?php echo esc_url( get_permalink() ); ?>" itemprop="url">

					<?php the_title(); ?>

				</a>

			</h3>

			<ul class="meta">
				<li><i class="fa fa-user"></i> <?php esc_html_e( 'By', 'lifeline-donation' ); ?> <a title="<?php ucwords( the_author_meta( 'display_name' ) ); ?>" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" itemprop="url"><?php ucwords( the_author_meta( 'display_name' ) ); ?></a></li>

				<li><i class="fa fa-calendar-o"></i><a href="<?php the_permalink() ?>"><?php echo get_the_date( get_option( 'date_format', get_the_ID() ) ); ?></a></li>
			</ul>


			<p itemprop="description">

				<?php the_excerpt(); ?>
			</p>
			<div class="btn-donate">
				<a title="<?php esc_attr( get_the_title() ); ?>" href="<?php echo esc_url( get_permalink( get_the_ID() ) ); ?>" itemprop="url"><?php echo esc_html_e( 'Donate Now', 'lifeline-donation' ); ?></a>
			</div>

		</div><!-- Post Detail -->

	</div>

</div>
</div>