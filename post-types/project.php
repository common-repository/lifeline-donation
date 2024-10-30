<?php
namespace LifelineDonation\PostTypes;

class Project
{
	public static $_instance;

	function init() {
		add_action( 'init', [$this, 'register'] );

		add_filter( 'post_updated_messages', [$this, 'updated_messages'] );

		add_action( 'load-options-permalink.php', [$this, 'load_permalinks'] );
	}

	public static function instance() {
		if(is_null(self::$_instance)) {
			self::$_instance = new self;
		}

		return self::$_instance;
	}

	/**
	 * Registers the `cause` post type.
	 */
	function register() {

		$status = webinane_donation_post_is_active('donation_projects_status');

		if( ! $status ) {
			return;
		}

		$slug = get_option('lifeline_donation_project_base');
		$slug = (! $slug) ? 'project' : $slug;

		$post_type = apply_filters('lifeline2_donation_project_post', [
			'slug'=> 'project',
			'args'=> apply_filters('webinane_donation_register_project_post_type', array(
				'labels'                => array(
					'name'                  => esc_html__( 'Projects', 'lifeline-donation' ),
					'singular_name'         => esc_html__( 'Project', 'lifeline-donation' ),
					'all_items'             => esc_html__( 'All Projects', 'lifeline-donation' ),
					'archives'              => esc_html__( 'Project Archives', 'lifeline-donation' ),
					'attributes'            => esc_html__( 'Project Attributes', 'lifeline-donation' ),
					'insert_into_item'      => esc_html__( 'Insert into project', 'lifeline-donation' ),
					'uploaded_to_this_item' => esc_html__( 'Uploaded to this project', 'lifeline-donation' ),
					'featured_image'        => _x( 'Featured Image', 'project', 'lifeline-donation' ),
					'set_featured_image'    => _x( 'Set featured image', 'project', 'lifeline-donation' ),
					'remove_featured_image' => _x( 'Remove featured image', 'project', 'lifeline-donation' ),
					'use_featured_image'    => _x( 'Use as featured image', 'project', 'lifeline-donation' ),
					'filter_items_list'     => esc_html__( 'Filter projects list', 'lifeline-donation' ),
					'items_list_navigation' => esc_html__( 'Projects list navigation', 'lifeline-donation' ),
					'items_list'            => esc_html__( 'Projects list', 'lifeline-donation' ),
					'new_item'              => esc_html__( 'New Project', 'lifeline-donation' ),
					'add_new'               => esc_html__( 'Add New', 'lifeline-donation' ),
					'add_new_item'          => esc_html__( 'Add New Project', 'lifeline-donation' ),
					'edit_item'             => esc_html__( 'Edit Project', 'lifeline-donation' ),
					'view_item'             => esc_html__( 'View Project', 'lifeline-donation' ),
					'view_items'            => esc_html__( 'View Projects', 'lifeline-donation' ),
					'search_items'          => esc_html__( 'Search projects', 'lifeline-donation' ),
					'not_found'             => esc_html__( 'No projects found', 'lifeline-donation' ),
					'not_found_in_trash'    => esc_html__( 'No projects found in trash', 'lifeline-donation' ),
					'parent_item_colon'     => esc_html__( 'Parent Project:', 'lifeline-donation' ),
					'menu_name'             => esc_html__( 'Projects', 'lifeline-donation' ),
				),
				'public'                => true,
				'hierarchical'          => false,
				'show_ui'               => true,
				'show_in_nav_menus'     => true,
				'supports'              => array( 'title', 'editor', 'thumbnail', 'author' ),
				'has_archive'           => true,
				'rewrite'               => array('slug' => $slug),
				'query_var'             => true,
				'menu_icon'             => 'dashicons-portfolio',
				'show_in_rest'          => true,
				'rest_base'             => 'project',
				'rest_controller_class' => 'WP_REST_Posts_Controller',
			) )
		]);

		if(empty($post_type)){
			return;
		}

		register_post_type( $post_type['slug'], $post_type['args']);

	}

	/**
	 * Sets the post updated messages for the `cause` post type.
	 *
	 * @param  array $messages Post updated messages.
	 * @return array Messages for the `cause` post type.
	 */
	function updated_messages( $messages ) {
		global $post;

		$status = webinane_donation_post_is_active('donation_projects_status');

		if( ! $status ) {
			return;
		}


		$permalink = get_permalink( $post );

		$messages['project'] = array(
			0  => '', // Unused. Messages start at index 1.
			/* translators: %s: post permalink */
			1  => sprintf( __( 'Project updated. <a target="_blank" href="%s">View project</a>', 'lifeline-donation' ), esc_url( $permalink ) ),
			2  => esc_html__( 'Custom field updated.', 'lifeline-donation' ),
			3  => esc_html__( 'Custom field deleted.', 'lifeline-donation' ),
			4  => esc_html__( 'Project updated.', 'lifeline-donation' ),
			/* translators: %s: date and time of the revision */
			5  => isset( $_GET['revision'] ) ? sprintf( __( 'Project restored to revision from %s', 'lifeline-donation' ), wp_post_revision_title( (int) sanitize_text_field($_GET['revision']), false ) ) : false,
			/* translators: %s: post permalink */
			6  => sprintf( __( 'Project published. <a href="%s">View project</a>', 'lifeline-donation' ), esc_url( $permalink ) ),
			7  => esc_html__( 'Project saved.', 'lifeline-donation' ),
			/* translators: %s: post permalink */
			8  => sprintf( __( 'Project submitted. <a target="_blank" href="%s">Preview project</a>', 'lifeline-donation' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
			/* translators: 1: Publish box date format, see https://secure.php.net/date 2: Post permalink */
			9  => sprintf( __( 'Project scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview project</a>', 'lifeline-donation' ),
			date_i18n( __( 'M j, Y @ G:i', 'lifeline-donation' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
			/* translators: %s: post permalink */
			10 => sprintf( __( 'Project draft updated. <a target="_blank" href="%s">Preview project</a>', 'lifeline-donation' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		);

		return $messages;
	}

	/**
	 * Set the permalink settings.
	 */
	function load_permalinks() {

        if( isset( $_POST['lifeline_donation_project_base'] ) ) {
            update_option( 'lifeline_donation_project_base', sanitize_title_with_dashes( $_POST['lifeline_donation_project_base'] ) );
        }
        if( isset( $_POST['lifeline_donation_project_cat_base'] ) ) {
            update_option( 'lifeline_donation_project_cat_base', sanitize_title_with_dashes( $_POST['lifeline_donation_project_cat_base'] ) );
        }
        
        // Add a settings field to the permalink page
        add_settings_field( 'lifeline_donation_project_base', __( 'Project Base', 'lifeline-donation' ), [$this, 'project_callback'], 'permalink', 'optional' );
        add_settings_field( 'lifeline_donation_proejct__cat_base', __( 'Project Category Base', 'lifeline-donation' ), [$this, 'project_category_callback'], 'permalink', 'optional' );
    }

    function project_callback()
    {
        $value = get_option( 'lifeline_donation_project_base' );   
        $value = ($value) ? $value : 'project'; 
        $is_multi = is_multisite() ? '' : '';
        echo $is_multi.'<input type="text" value="' . esc_attr( $value ) . '" name="lifeline_donation_project_base" id="lifeline_donation_project_base" class="regular-text" />';
    }

    /**
     * Cause Category slug
     */
    function project_category_callback()
    {
        $value = get_option( 'lifeline_donation_project_cat_base' );
        $value = ($value) ? $value : 'project_cat';

        $is_multi = is_multisite() ? '' : '';
        echo $is_multi.'<input type="text" value="' . esc_attr( $value ) . '" name="lifeline_donation_project_cat_base" id="lifeline_donation_project_cat_base" class="regular-text" />';
    }

}


Project::instance()->init();

