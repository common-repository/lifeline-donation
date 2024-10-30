<?php

/**
 * Registers the `project_cat` taxonomy,
 * for use with 'project'.
 */
function webinane_donation_project_cat_init() {
	
	$status = webinane_donation_post_is_active('donation_projects_status');

	if( ! $status ) {
		return;
	}

	$slug = get_option('lifeline_donation_project_cat_base');
	$slug = (! $slug) ? 'project_cat' : $slug;
    
	register_taxonomy( 'project_cat', array( 'project' ), apply_filters('webinane_donation_register_project_cat_taxonomy', array(
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
			'name'                       => esc_html__( 'Project categories', 'lifeline-donation' ),
			'singular_name'              => _x( 'Project category', 'taxonomy general name', 'lifeline-donation' ),
			'search_items'               => esc_html__( 'Search Project categories', 'lifeline-donation' ),
			'popular_items'              => esc_html__( 'Popular Project categories', 'lifeline-donation' ),
			'all_items'                  => esc_html__( 'All Project categories', 'lifeline-donation' ),
			'parent_item'                => esc_html__( 'Parent Project category', 'lifeline-donation' ),
			'parent_item_colon'          => esc_html__( 'Parent Project category:', 'lifeline-donation' ),
			'edit_item'                  => esc_html__( 'Edit Project category', 'lifeline-donation' ),
			'update_item'                => esc_html__( 'Update Project category', 'lifeline-donation' ),
			'view_item'                  => esc_html__( 'View Project category', 'lifeline-donation' ),
			'add_new_item'               => esc_html__( 'Add New Project category', 'lifeline-donation' ),
			'new_item_name'              => esc_html__( 'New Project category', 'lifeline-donation' ),
			'separate_items_with_commas' => esc_html__( 'Separate project categories with commas', 'lifeline-donation' ),
			'add_or_remove_items'        => esc_html__( 'Add or remove project categories', 'lifeline-donation' ),
			'choose_from_most_used'      => esc_html__( 'Choose from the most used project categories', 'lifeline-donation' ),
			'not_found'                  => esc_html__( 'No project categories found.', 'lifeline-donation' ),
			'no_terms'                   => esc_html__( 'No project categories', 'lifeline-donation' ),
			'menu_name'                  => esc_html__( 'Category', 'lifeline-donation' ),
			'items_list_navigation'      => esc_html__( 'Project Categories list navigation', 'lifeline-donation' ),
			'items_list'                 => esc_html__( 'Project Categories list', 'lifeline-donation' ),
			'most_used'                  => _x( 'Most Used', 'project_cat', 'lifeline-donation' ),
			'back_to_items'              => esc_html__( '&larr; Back to Project cats', 'lifeline-donation' ),
		),
		'show_in_rest'      => true,
		'rest_base'         => 'project_cat',
		'rest_controller_class' => 'WP_REST_Terms_Controller',
	) ) );

}
add_action( 'init', 'webinane_donation_project_cat_init' );

/**
 * Sets the post updated messages for the `project_cat` taxonomy.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `project_cat` taxonomy.
 */
function webinane_donation_project_cat_updated_messages( $messages ) {

	$settings = wpcm_get_settings()->get('donation_projects_status');

	if( ! $settings ) {
		return;
	}

	$messages['project_cat'] = array(
		0 => '', // Unused. Messages start at index 1.
		1 => esc_html__( 'Project category added.', 'lifeline-donation' ),
		2 => esc_html__( 'Project category deleted.', 'lifeline-donation' ),
		3 => esc_html__( 'Project category updated.', 'lifeline-donation' ),
		4 => esc_html__( 'Project category not added.', 'lifeline-donation' ),
		5 => esc_html__( 'Project category not updated.', 'lifeline-donation' ),
		6 => esc_html__( 'Project category deleted.', 'lifeline-donation' ),
	);

	return $messages;
}
add_filter( 'term_updated_messages', 'webinane_donation_project_cat_updated_messages' );