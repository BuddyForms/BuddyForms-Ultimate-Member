<?php

// You could set the default privacy for custom tab and disable to change the tab privacy settings in admin menu.
/*
* There are values for 'default_privacy' atribute
* 0 - Anyone,
* 1 - Guests only,
* 2 - Members only,
* 3 - Only the owner
*/
// Filter
function buddyforms_cpublishing_um_add_tab( $tabs ) {
	$tabs['buddyforms_cpublishing'] = array(
		'name' 				=> 'Collaborative Posts',
		'icon' 				=> 'um-faicon-pencil',
//		'custom' => true,
		'default_privacy'   => 3,
	);
	return $tabs;
}
add_filter( 'um_profile_tabs', 'buddyforms_cpublishing_um_add_tab', 9999 );
add_filter( 'um_user_profile_tabs', 'buddyforms_cpublishing_um_add_tab', 9999 );

/**
 * Check an ability to view tab
 *
 * @param $tabs
 *
 * @return mixed
 */
function buddyforms_cpublishing_um_add_tab_visibility( $tabs ) {
	if ( empty( $tabs['buddyforms_cpublishing'] ) ) {
		return $tabs;
	}

	$user_id = um_profile_id();

	if ( ! user_can( $user_id, '{here some capability which you need to check}' ) ) {
		unset( $tabs['buddyforms_cpublishing'] );
	}

	return $tabs;
}
add_filter( 'um_user_profile_tabs', 'buddyforms_cpublishing_um_add_tab_visibility', 2000, 1 );

// Action
function um_profile_content_buddyforms_cpublishing_default( $args ) {
	echo do_shortcode('[buddyforms_list_editor_posts]');
}
add_action( 'um_profile_content_buddyforms_cpublishing_default', 'um_profile_content_buddyforms_cpublishing_default' );