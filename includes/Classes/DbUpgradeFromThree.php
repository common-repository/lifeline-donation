<?php

namespace LifelineDonation\Classes;

class DbUpgradeFromThree
{
	static function init() {
		self::runDbUpgrade();
	}

	static function runDbUpgrade() {
		global $post;

		$cause_meta = array(
			'donation_needed' => 'donation',
			'donation_collected' => 'donation_collected',
			'location' => 'location',
			'show_title_section' => 'show_title',
			'title_section_bg_id' => 'title_section_bg',
			'layout' => 'sidebar_layout',
			'cause_format' => 'cause_format',
			'metaSidebar' => 'sidebar',
			'banner_breadcrumb' => 'show_breadcrumbs',
			'cause_video'   => 'donation_cause_video',
			'cause_images'  => 'donation_cause_gallery',
		);
		$query = new WP_Query(
			array(
				'post_type' => 'lif_causes',
				'posts_per_page' => 5,
			)
		);

		if ( $query->have_posts() ) {

			while ( $query->have_posts() ) {
				$query->the_post();

				$postdata = (array) $post;
				$postdata['post_type'] = 'cause';

				$meta = get_post_meta( get_the_id() );

				$newmeta = array();
				foreach ( $cause_meta as $old_key => $new_key ) {
					$found = webinane_set( $meta, $old_key );
					if ( $found ) {
						$found = current( $found );

						if ( 'on' == $found ) {
							$found = true;
						}
						if ( 'cause_image' == $old_key ) {
							$unserial = maybe_unserialize( $found );
							$found = array();
							foreach ( $unserial as $attachment_id => $f ) {
								$found[] = $attachment_id;
							}
							$found = implode( ',', $found );
						}

						$newmeta[ $new_key ] = $found;
					}
				}
				update_post_meta( get_the_id(), 'causes_settings', $newmeta );

				$cats = wp_get_post_terms( get_the_id(), 'causes_category' );

				if ( $cats ) {
					foreach ( $cats as $cat ) {
						$catdata = (array) $cat;
						$catdata['taxonomy'] = 'cause_cat';

						$term_res = get_term_by( 'name', $cat->name, 'cause_cat' );
						if ( ! $term_res ) {
							$term_res = wp_insert_term( $cat->name, 'cause_cat', $catdata );
						}

						if ( ! is_wp_error( $term_res ) ) {
							$term_res = (array) $term_res;
							wp_set_post_terms( get_the_id(), array( $term_res['term_id'] ), 'cause_cat', true );
						}
					}
				}

				wp_update_post( $postdata, true );
			}
		} else {
			/**
			 * If we have done with causes then we'll start with projects
			 */
			self::update_projects_db();
		}
		wp_reset_postdata();
	}

	/**
	 * Update the custom post type projects in database.
	 *
	 * @return void [description]
	 */
	public static function update_projects_db() {
		global $post;
		$cause_meta = array(
			'donation_needed' => 'donation',
			'donation_collected' => 'donation_collected',
			'location' => 'location',
			'show_title_section' => 'show_title',
			'title_section_bg_id' => 'title_section_bg',
			'layout' => 'sidebar_layout',

			'metaSidebar' => 'sidebar',
			'banner_breadcrumb' => 'show_breadcrumbs',
		);

		$query = new WP_Query(
			array(
				'post_type' => 'lif_project',
				'posts_per_page' => 5,
			)
		);

		if ( $query->have_posts() ) {

			while ( $query->have_posts() ) {
				$query->the_post();

				$postdata = (array) $post;
				$postdata['post_type'] = 'project';

				$meta = get_post_meta( get_the_id() );

				$newmeta = array();
				foreach ( $cause_meta as $old_key => $new_key ) {
					$found = webinane_set( $meta, $old_key );
					if ( $found ) {
						$found = current( $found );

						if ( 'on' == $found ) {
							$found = true;
						}
						if ( 'cause_images' == $old_key ) {
							$unserial = maybe_unserialize( $found );
							$found = array();
							foreach ( $unserial as $attachment_id => $f ) {
								$found[] = $attachment_id;
							}
							$found = implode( ',', $found );
						}

						$newmeta[ $new_key ] = $found;
					}
				}
				update_post_meta( get_the_id(), 'project_settings', $newmeta );

				$cats = wp_get_post_terms( get_the_id(), 'project_category' );
				get_query_var( $var, $default = '' );
				if ( $cats ) {
					foreach ( $cats as $cat ) {
						$catdata = (array) $cat;
						$catdata['taxonomy'] = 'project_cat';

						$term_res = get_term_by( 'name', $cat->name, 'project_cat' );
						if ( ! $term_res ) {
							$term_res = wp_insert_term( $cat->name, 'project_cat', $catdata );
						}

						if ( ! is_wp_error( $term_res ) ) {
							$term_res = (array) $term_res;
							wp_set_post_terms( get_the_id(), array( $term_res['term_id'] ), 'project_cat', true );
						}
					}
				}

				wp_update_post( $postdata, true );
			}
		} else {
			update_option( 'webinane_commerce_database_update_scheduled', 0 );
			delete_transient( 'webinane_commerce_db_upgrade_status' );
			set_transient( 'webinane_commerce_db_upgrade_status', 'NO', ( 60 * 60 * 24 ) );
		}
		wp_reset_postdata();
	}

	/**
	 * Database migration for lifeline2, update theme options.
	 *
	 * @return void [description]
	 */
	public static function update_theme_options() {
		_deprecated_function( __FUNCTION__, '0.1.0', 'No replacement' );
		$paypal = get_option( 'wp_donation_papypal_settings' );
		$paypal = webinane_set( $paypal, 'wp_donation_papypal_settings' );

		$settings = wpcm_get_settings();

		if ( $paypal ) {
			$pp_settings = array(
				'paypal_api_username' => webinane_set( $paypal, 'api_user' ),
				'paypal_api_password' => webinane_set( $paypal, 'api_pass' ),
				'paypal_api_signature' => webinane_set( $paypal, 'api_sign' ),
				'paypal_sandbox_status' => ( webinane_set( $paypal, 'type' ) == 'sandbox' ) ? true : false,
				'paypal_email'  => webinane_set( $paypal, 'user' ),
				'paypal_express_gateway_status' => ( webinane_set( $paypal, 'status' ) == 'enable' ) ? true : false,
			);
			$settings->merge( $pp_settings );
		}
	}
}