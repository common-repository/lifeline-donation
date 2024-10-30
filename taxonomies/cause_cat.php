<?php

/**
 * Registers the `cause_Category` taxonomy,
 * for use with 'cause'.
 */
function webinane_donation_cause_Category_init() {
	
    $status = webinane_donation_post_is_active('donation_causes_status');

	if( ! $status ) {
		return;
	}

	$slug = get_option('lifeline_donation_cause_cat_base');
	$slug = (! $slug) ? 'project_cat' : $slug;

	register_taxonomy( 'cause_cat', array( 'cause' ), apply_filters('webinane_donation_register_cause_cat_taxonomy', array(
		'hierarchical'      => true,
		'public'            => true,
		'show_in_nav_menus' => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array('slug' => $slug),
		'capabilities'      => array(
			'manage_terms'  => 'edit_posts',
			'edit_terms'    => 'edit_posts',
			'delete_terms'  => 'edit_posts',
			'assign_terms'  => 'edit_posts',
		),
		'labels'            => array(
			'name'                       => esc_html__( 'Cause Categories', 'lifeline-donation' ),
			'singular_name'              => _x( 'Cause Category', 'taxonomy general name', 'lifeline-donation' ),
			'search_items'               => esc_html__( 'Search Cause Categories', 'lifeline-donation' ),
			'popular_items'              => esc_html__( 'Popular Cause Categories', 'lifeline-donation' ),
			'all_items'                  => esc_html__( 'All Cause Categories', 'lifeline-donation' ),
			'parent_item'                => esc_html__( 'Parent Cause Category', 'lifeline-donation' ),
			'parent_item_colon'          => esc_html__( 'Parent Cause Category:', 'lifeline-donation' ),
			'edit_item'                  => esc_html__( 'Edit Cause Category', 'lifeline-donation' ),
			'update_item'                => esc_html__( 'Update Cause Category', 'lifeline-donation' ),
			'view_item'                  => esc_html__( 'View Cause Category', 'lifeline-donation' ),
			'add_new_item'               => esc_html__( 'Add New Cause Category', 'lifeline-donation' ),
			'new_item_name'              => esc_html__( 'New Cause Category', 'lifeline-donation' ),
			'separate_items_with_commas' => esc_html__( 'Separate cause Categories with commas', 'lifeline-donation' ),
			'add_or_remove_items'        => esc_html__( 'Add or remove cause Categories', 'lifeline-donation' ),
			'choose_from_most_used'      => esc_html__( 'Choose from the most used cause Categories', 'lifeline-donation' ),
			'not_found'                  => esc_html__( 'No cause Categories found.', 'lifeline-donation' ),
			'no_terms'                   => esc_html__( 'No cause Categories', 'lifeline-donation' ),
			'menu_name'                  => esc_html__( 'Categories', 'lifeline-donation' ),
			'items_list_navigation'      => esc_html__( 'Cause Categories list navigation', 'lifeline-donation' ),
			'items_list'                 => esc_html__( 'Cause Categories list', 'lifeline-donation' ),
			'most_used'                  => _x( 'Most Used', 'cause_Category', 'lifeline-donation' ),
			'back_to_items'              => esc_html__( '&larr; Back to Cause Categories', 'lifeline-donation' ),
		),
		'show_in_rest'      => true,
		'rest_base'         => 'cause_cat',
		'rest_controller_class' => 'WP_REST_Terms_Controller',
	) ) );

}
add_action( 'init', 'webinane_donation_cause_Category_init' );

/**
 * Sets the post updated messages for the `cause_Category` taxonomy.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `cause_Category` taxonomy.
 */
function webinane_donation_cause_Category_updated_messages( $messages ) {

	$settings = wpcm_get_settings()->get('donation_causes_status');

	if( $settings != 'true' ) {
		return;
	}

	$messages['cause_Category'] = array(
		0 => '', // Unused. Messages start at index 1.
		1 => esc_html__( 'Cause Category added.', 'lifeline-donation' ),
		2 => esc_html__( 'Cause Category deleted.', 'lifeline-donation' ),
		3 => esc_html__( 'Cause Category updated.', 'lifeline-donation' ),
		4 => esc_html__( 'Cause Category not added.', 'lifeline-donation' ),
		5 => esc_html__( 'Cause Category not updated.', 'lifeline-donation' ),
		6 => esc_html__( 'Cause Categories deleted.', 'lifeline-donation' ),
	);

	return $messages;
}
add_filter( 'term_updated_messages', 'webinane_donation_cause_Category_updated_messages' );