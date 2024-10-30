<?php
/**
 * [webinane_donation_template description]
 *
 * @param  string $template_names     [description].
 * @param  boolean $load [description].
 * @param  boolean $require_once      [description].
 * @return [type]           [description]
 */
function webinane_donation_template( $template_names, $load = false, $require_once = true ) {
	
	if(file_exists(get_theme_file_path( 'lifeline-donation/' . $template_names ))) {
		return get_theme_file_path( 'lifeline-donation/' . $template_names );
	}

	if ( file_exists( LIFELINE_DONATION_PATH . 'templates/' . $template_names ) ) {
		$located = LIFELINE_DONATION_PATH . 'templates/' . $template_names;
	}
	if ( $load && '' != $located ) {
		load_template( $located, $require_once );
	}
	return $located;
}
/**
 * [webinane_donation_template_load description]
 *
 * @param  string $template [description]
 * @param  array  $args     [description]
 * @return [type]           [description]
 */
function webinane_donation_template_load( $templ = '', $args = array() ) {
	$templ = webinane_donation_template( $templ );
	if ( file_exists( $templ ) ) {
		extract( $args );
		unset( $args );
		include $templ;
	}
}
/**
 * Check wether some settings are enabled or not.
 * 
 * @param  [type] $status_key [description]
 * @return [type]             [description]
 */
function webinane_donation_post_is_active($status_key) {
	$settings = wpcm_get_settings()->toArray();
	$status = isset($settings[$status_key]) ? $settings[$status_key] : true;
	if( $status === 'false' ) {
		$status = false;
	}
	return $status;
}
/**
 * loop through the give config and set the default values.
 *
 * @param  [type] $config  [description]
 * @param  [type] $options [description]
 * @return [type]          [description]
 */
function webinane_donation_set_default_config($config, $options) {
	_deprecated_function( 'webinane_donation_set_default_config', '0.1.0' );
	foreach( $config as $conf ) {
		foreach( $config['fields'] as $field) {
			if( ! isset( $options[ $field['id'] ] ) ) {
				$options[ $field['id'] ] = isset($field['default']) ? $field['default'] : '';
			}
		}
	}
	return $options;
}
/**
 * Load the custom template.
 * 
 * @param  string $template default template path.
 * @return string           pathe to the template
 */
function webinane_donations_single_template($template) {
	global $post;

	if ($post->post_type == "cause"){
		$path = get_theme_file_path( 'lifeline-donation/single-cause.php' );

		if( file_exists($path) ) {
			return $path;
		}
		return LIFELINE_DONATION_PATH . "templates/single-cause.php";
	}
	if ($post->post_type == "project"){
		$path = get_theme_file_path( 'lifeline-donation/single-project.php' );
		if( file_exists($path) ) {
			return $path;
		}
		return LIFELINE_DONATION_PATH . "templates/single-project.php";
	}
	return $template;
}
add_filter('single_template', 'webinane_donations_single_template');
/**
 * Load the custom template.
 * 
 * @param  string $template default template path.
 * @return string           pathe to the template
 */
function webinane_donations_post_archive_template($template) {
	if ( is_post_type_archive ( 'cause' ) ) {
		$path = get_theme_file_path( 'lifeline-donation/archive-cause.php' );
		if( file_exists($path) ) { 
			return $path;
		}
		else {
			return LIFELINE_DONATION_PATH . 'templates/archive-cause.php';
		}
	}
	if ( is_post_type_archive ( 'project' ) ) {
		$path = get_theme_file_path( 'lifeline-donation/archive-project.php' );
		if( file_exists($path) ) {
			return $path;
		}
		else {
			return LIFELINE_DONATION_PATH . 'templates/archive-project.php';
		}
	}
	return $template;
}

add_filter( 'archive_template', 'webinane_donations_post_archive_template' ) ;

/**
 * Load the custom template.
 * 
 * @param  string $template default template path.
 * @return string           pathe to the template
 */
function webinane_donations_post_taxonomy_template($template) {
	if( is_tax( 'cause_cat' ) ) {
		$path = get_theme_file_path( 'lifeline-donation/taxonomy-cause_cat.php' );
		if( file_exists($path) ) {
			return $path;
		}
		else {
			return LIFELINE_DONATION_PATH . 'templates/taxonomy-cause_cat.php';
		}
	}
	if( is_tax( 'project_cat' ) ) {
		$path = get_theme_file_path( 'lifeline-donation/taxonomy-project_cat.php' );
		if( file_exists($path) ) {
			return $path;
		}
		else {
			return LIFELINE_DONATION_PATH . 'templates/taxonomy-project_cat.php';
		}
	}
	return $template;
}
add_filter( 'archive_template', 'webinane_donations_post_taxonomy_template' ) ;
/**
 * VC Font container output.
 * 
 * @param  [type] $data   [description]
 * @param  string $family [description]
 * @return [type]         [description]
 */
function wi_donation_vc_font_container($data, $family = '', $content) {
	extract(wi_donation_build_font_container($data, $family, $content));
	return '<'.$tag.' style="'.$str.'">'.$content.'</'.$tag.'>';
}
/**
 * [wi_donation_build_font_container description]
 * 
 * @param  [type] $data    [description]
 * @param  string $family  [description]
 * @param  [type] $content [description]
 * @return [type]          [description]
 */
function wi_donation_build_font_container($data, $family = '', $content) {
	$def = array(
		'tag'=>'h2',
        'text_align' => 'inherit',
        'font_size' => 'inherit',
        'line_height' => 'inherit',
        'color' => 'inherit',
	);
	$data = wi_donation_vc_parse($data);
	$family = wi_donation_vc_parse($family);
	$data = wp_parse_args( $data, $def );
	$data = wp_parse_args( $data, $family );
	$tag = $data['tag'];
	unset($data['tag']);
	$str = '';
	foreach( $data as $att => $dat ) {
		if( $att == 'font_style' ) {
			$att = 'font_weight';
			$dat = webinane_set(explode(' ', $dat), 0);
		}
		if( $dat == 'inherit' ) {
			continue;
		}
		$str .= str_replace('_', '-', $att).':'.$dat.';';
	}
	return compact('tag', 'str');
}
/**
 * [wi_donation_vc_parse description]
 * 
 * @param  [type] $str [description]
 * @return [type]      [description]
 */
function wi_donation_vc_parse($str) {
	$data = explode('|', urldecode($str) );
	$newarr = array();
	foreach( $data as $dat ) {
		$exploded = explode(':', $dat);
		$newarr[$exploded[0]] = $exploded[1];
	}
	return $newarr;
}
add_filter('vc_google_fonts_get_fonts_filter', 'wi_vc_google_fonts_get_fonts_filter');
function wi_vc_google_fonts_get_fonts_filter($fonts) {
	$barlow = array(
		'font_family'	=> 'Barlow',
		'font_styles'	=> 'regular,italic',
		'font_types'	=> '400 regular:400:normal,400 italic:400:italic,700 regular:700:normal,700 italic:700:italic',
	);
	$fonts[] = (object)$barlow;
	return $fonts;
}


function webinane_donation_get_categories($arg = FALSE, $slug = FALSE, $vp = FALSE) {
        global $wp_taxonomies;
        $categories = get_categories($arg);
        $cats = array();
        if (is_wp_error($categories)) {
            return array('' => 'All');
        }
        if (webinane_set($arg, 'show_all') && $vp) {
            $cats[] = array('value' => 'all', 'label' => esc_html__('All Categories', 'lifeline-donation'));
        } elseif (webinane_set($arg, 'show_all')) {
            $cats['all'] = esc_html__('All Categories', 'lifeline-donation');
        }
        if (!webinane_set($categories, 'errors')) {
            foreach ($categories as $category) {
                if ($vp) {
                    $key = ($slug) ? $category->slug : $category->term_id;
                    $cats[] = array('value' => $key, 'label' => $category->name);
                } else {
                    $key = ($slug) ? $category->slug : $category->term_id;
                    $cats[$key] = $category->name;
                }
            }
        }
        return $cats;
    }
    function webinane_donation_get_posts_blocks( $post_type = 'post' ) {

		global $wpdb;

		$res = $wpdb->get_results( $wpdb->prepare( "SELECT `post_name`, `post_title` FROM `" . $wpdb->prefix . "posts` WHERE `post_type` = %s AND `post_status` = %s ", array($post_type, 'publish' ) ), ARRAY_A );

		$return = array();

		foreach ( $res as $k => $r ) {

				$return[ webinane_set( $r, 'post_name' ) ] = webinane_set( $r, 'post_title' );
		}
		return $return;
	}

function webinane_nav_donation_menu($items, $args) {

	/*echo '<style>
	.menu-dnt-btn a {
	    color: '.wpcm_get_settings()->get('menu_donation_button_font_color').' !important;
	    background-color: '.wpcm_get_settings()->get('menu_donation_button_color').';
	    padding: 15px 40px;
	    border-style: double;
	    font-size: 18px;
	}
	</style>';*/
	// printr(wpcm_get_settings());

	if( wpcm_get_settings()->get('menu_donation_button') && wpcm_get_settings()->get('menu_donation_button_title') != '' ) {

		$location =  wpcm_get_settings()->get('menu_donation_button_theme_location', 'primary-menu');

		if ( $args->theme_location == $location ) {

			$file = get_theme_file_path( 'lifeline-donation/global/menu-donation-button.php' );
			if( ! file_exists($file) ) {

				$file = LIFELINE_DONATION_PATH . 'templates/global/menu-donation-button.php';
			}
			ob_start();
			include $file;
			$items .= ob_get_clean();
			if( $post_id ) {
				$items .= '';
			}
		}
	}
	return $items;
}
add_filter('wp_nav_menu_items', 'webinane_nav_donation_menu', 10, 2);

function wi_donation_shortcode_atts($tag, $atts) {
	if( function_exists('vc_map_get_attributes') ) {
		return vc_map_get_attributes($tag, $atts);
	}

	$fields = LifelineDonation\Shortcodes\Shortcodes::$fields;
	$params = array_get($fields, $tag);
	if( $params ) {
		
		$new_atts = array();
		foreach( $params['params'] as $param) {
			$new_atts[$param['param_name']] = array_get($atts, $param['param_name']);
		}
		return $new_atts;
	}
	return $atts;
}

function wi_donation_getExtraClass( $el_class ) {
	$output = '';
	if ( '' !== $el_class ) {
		$output = ' ' . str_replace( '.', '', $el_class );
	}

	return $output;
}