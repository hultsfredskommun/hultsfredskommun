<?php
/**
 * Activate Add-ons
 * Here you can enter your activation codes to unlock Add-ons to use in your theme.
 * Since all activation codes are multi-site licenses, you are allowed to include your key in premium themes.
 * Use the commented out code to update the database with your activation code.
 * You may place this code inside an IF statement that only runs on theme activation.
 */

// if(!get_option('acf_repeater_ac')) update_option('acf_repeater_ac', "xxxx-xxxx-xxxx-xxxx");
// if(!get_option('acf_options_page_ac')) update_option('acf_options_page_ac', "xxxx-xxxx-xxxx-xxxx");
// if(!get_option('acf_flexible_content_ac')) update_option('acf_flexible_content_ac', "xxxx-xxxx-xxxx-xxxx");
// if(!get_option('acf_gallery_ac')) update_option('acf_gallery_ac', "xxxx-xxxx-xxxx-xxxx");


/**
 * Register field groups
 * The register_field_group function accepts 1 array which holds the relevant data to register a field group
 * You may edit the array as you see fit. However, this may result in errors if the array is not compatible with ACF
 * This code must run every time the functions.php file is read
 */
add_action('acf/init',  'hk_acf_op_init');
function hk_acf_op_init() {
	if( function_exists('acf_add_options_page') ) {
		acf_add_options_page(array(
			'page_title' 	=> 'Hultsfred',
			'menu_title'	=> 'Hultsfred',
			'menu_slug' 	=> 'hultsfred-options',
			'capability'	=> 'administrator',
			'redirect'		=> false
		));
		$user_can_edit = (!get_field('user_permissions_driftstorningar', 'options') || get_field('user_can_edit_driftstorningar', 'user_' . get_current_user_id())) ? true : false;
		if ($user_can_edit) {	
			acf_add_options_sub_page(array(
				'page_title' 	=> 'Driftstörningar',
				'menu_title'	=> 'Driftstörningar',
				'parent_slug'	=> 'hultsfred-options',
			));
		}
		$user_can_edit = get_field('user_can_edit_hultsfred_admin', 'user_' . get_current_user_id()) ? true : false;
		if ($user_can_edit) {	
			acf_add_options_sub_page(array(
				'page_title' 	=> 'Admin',
				'menu_title'	=> 'Admin',
				'parent_slug'	=> 'hultsfred-options',
			));
		}

	}

}

add_action('init', 'hk_acf_init_options');
function hk_acf_init_options() {
	if( function_exists('acf_add_local_field_group') ) :
		// only show user fields to admins
		if ( (is_multisite() && is_super_admin()) || (!is_multisite() && current_user_can('administrator')) ) :
			require_once( get_template_directory() . '/inc/acf/user.php' );
		endif;
		require_once( get_template_directory() . '/inc/acf/options.php' );
		require_once( get_template_directory() . '/inc/acf/hultsfred.php' );
		require_once( get_template_directory() . '/inc/acf/mellanstartsida.php' );
		require_once( get_template_directory() . '/inc/acf/driftstorning.php' );
		require_once( get_template_directory() . '/inc/acf/bubble.php' );
		require_once( get_template_directory() . '/inc/acf/category.php' );
		require_once( get_template_directory() . '/inc/acf/forum.php' );
	endif;
	if ( function_exists('register_field_group') ) :
		require_once( get_template_directory() . '/inc/acf/page.php' );
		require_once( get_template_directory() . '/inc/acf/post.php' );
		require_once( get_template_directory() . '/inc/acf/contact.php' );
		require_once( get_template_directory() . '/inc/acf/media.php' );
	endif;

}

?>
