<?php

//
// Load all needed css and js
// @todo: this should not be global.
//
function bf_um_front_js_css_loader( $fount ) {
	return true;
}

add_filter( 'buddyforms_front_js_css_loader', 'bf_um_front_js_css_loader', 10, 1 );

//
// Helper function to get the parent slug for the profil navigation
// Coppy of function rewrite_rules /ultimate-member/core/um-rewrite.php line 31
// @todo: crearte a pull request to fire the rewrire function if set to not load automaticaly...?!

function bf_ultimate_member_parent_tab( $member_form ) {

	// By default use the form slug for the tab
	$parent_tab_name = $member_form['slug'];

	// Check if form is a sub tab of a parent.
	if ( isset( $member_form['ultimate_members_profiles_parent_tab'] ) ) {
		$parent_tab = $member_form['ultimate_members_profiles_parent_tab'];
	}

	// If the form is a sub form of a parent tab get the attached page slug as parent.
	if ( isset( $member_form['attached_page'] ) && isset( $parent_tab ) ) {
		$attached_page   = $member_form['attached_page'];
		$parent_tab_page = get_post( $attached_page, 'OBJECT' );
		$parent_tab_name = $parent_tab_page->post_name;
	}

	return $parent_tab_name;
}

//
// Prevent Ultimate Member from flush rewrite roles bei every page load.
// @todo: Rewrite roles should get flushed by every option save form Ultimate Member
//
add_filter( 'um_rewrite_flush_rewrite_rules', 'buddyforms_um_rewrite_flush_rewrite_rules' );
function buddyforms_um_rewrite_flush_rewrite_rules() {
	return true;
}
