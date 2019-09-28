<?php

// Create the Form Builder Sidebar Metabox
function buddyforms_ultimate_members_admin_settings_sidebar_metabox() {
	add_meta_box( 'buddyforms_ultimate_members', __( "Ultimate Members", 'buddyforms' ), 'buddyforms_ultimate_members_admin_settings_sidebar_metabox_html', 'buddyforms', 'normal', 'low' );
	add_filter( 'postbox_classes_buddyforms_buddyforms_ultimate_members', 'buddyforms_metabox_class' );
	add_filter( 'postbox_classes_buddyforms_buddyforms_ultimate_members', 'buddyforms_metabox_hide_if_form_type_register' );
	add_filter( 'postbox_classes_buddyforms_buddyforms_ultimate_members', 'buddyforms_metabox_show_if_attached_page' );
}


// Form Builder Sidebar Metabox Content
function buddyforms_ultimate_members_admin_settings_sidebar_metabox_html() {
	global $post, $buddyforms;

	// Only integrate if we are in theh frombuilder
	if ( $post->post_type != 'buddyforms' ) {
		return;
	}

	// Get the form options
	$buddyform = get_post_meta( get_the_ID(), '_buddyforms_options', true );

	// Create an array for the form elements
	$form_setup = array();


	// Get the form element values from the form options array
	$ultimate_members_profiles_integration = isset( $buddyform['ultimate_members_profiles_integration'] ) ? $buddyform['ultimate_members_profiles_integration'] : '';
	$ultimate_members_profiles_parent_tab  = isset( $buddyform['ultimate_members_profiles_parent_tab'] ) ? $buddyform['ultimate_members_profiles_parent_tab'] : '';


	if( isset($buddyform['slug']) ){
		if ( $buddyform['slug'] == 'posts' && ! empty( $ultimate_members_profiles_integration ) &&
		     $buddyform['slug'] == 'posts' && empty( $ultimate_members_profiles_parent_tab ) ) {
			$message      = __( '<font color="#b22222">This Form is Broken!</font> This form slug is "posts". This slug is reserved for the Ultimate Member Posts Tab. You can only Use Attached Page as Parent Tab and make this form a sub tab of the parent. Please check both options', 'buddyforms' );
			$form_setup[] = new Element_HTML( '<div class="notice notice-error"><p>' . $message . '</p></div><p><b>' . $message . '</b></p>' );
		}
	}

	// Add the form elements
	$form_setup[] = new Element_Checkbox( "<b>" . __( 'Add this form as Profile Tab', 'buddyforms' ) . "</b>", "buddyforms_options[ultimate_members_profiles_integration]", array( "integrate" => "Integrate this Form" ), array(
		'value'     => $ultimate_members_profiles_integration,
		'shortDesc' => __( 'Many forms can share the same attached page. All Forms with the same attached page can be grouped together with this option. All Forms will be listed as sub nav tabs of the page main nav', 'buddyforms' )
	) );
	$form_setup[] = new Element_Checkbox( "<br><b>" . __( 'Use Attached Page as Parent Tab and make this form a sub tab of the parent', 'buddyforms' ) . "</b>", "buddyforms_options[ultimate_members_profiles_parent_tab]", array( "attached_page" => "Use Attached Page as Parent" ), array(
		'value'     => $ultimate_members_profiles_parent_tab,
		'shortDesc' => __( 'Many Forms can have the same attached Page. All Forms with the same page with page as parent enabled will be listed as sub forms. This why you can group forms.', 'buddyforms' )
	) );

	if ( defined('um_activity_url') ) {
		$ultimate_members_social_activity  = isset( $buddyform['ultimate_members_social_activity'] ) ? $buddyform['ultimate_members_social_activity'] : '';
		$element = new Element_Checkbox( "<br><b>" . __( 'Social Activity Integration', 'buddyforms' ) . "</b>", "buddyforms_options[ultimate_members_social_activity]", array( "enabled" => "Integrate" ), array(
			'value'     => $ultimate_members_social_activity,
			'shortDesc' => __( 'List submissions in the social activity wall', 'buddyforms' )
		) );
		if ( buddyforms_um_fs()->is_not_paying() && ! buddyforms_um_fs()->is_trial() ) {
			$element->setAttribute( 'disabled', 'disabled' );
		}
		$form_setup[] = $element;

	}


	$um_profile_visibility = isset( $buddyform['um_profile_visibility'] ) ? $buddyform['um_profile_visibility'] : 'private';
	$element = new Element_Select( "<br><b>" . __( 'Visibility', 'buddyforms' ) . "</b>", "buddyforms_options[um_profile_visibility]", array( "private"        => "Private - Only the logged in member in his profile.",
	                                                                                                                                            "logged_in_user" => "Community - Logged in user can see other users profile posts",
	                                                                                                                                            "any"            => "Public Visible - Unregistered users can see user profile posts"
	), array( 'value'     => $um_profile_visibility,
	          'shortDesc' => __( 'Who can see submissions in Profiles?', 'buddyforms' )
	) );
	if ( buddyforms_um_fs()->is_not_paying() && ! buddyforms_um_fs()->is_trial() ) {
		$element->setAttribute( 'disabled', 'disabled' );
	}
	$form_setup[] = $element;


	$um_profile_menu_label = isset( $buddyform['um_profile_menu_label'] ) ? $buddyform['um_profile_menu_label'] : '';
	$element = new Element_Textbox( "<br><b>" . __( 'Label', 'buddyforms' ) . "</b>", "buddyforms_options[um_profile_menu_label]", array( 'value'     => $um_profile_menu_label,
	                                                                                                                                      'shortDesc' => __( 'Profile Tab Label', 'buddyforms' )
	) );
	if ( buddyforms_um_fs()->is_not_paying() && ! buddyforms_um_fs()->is_trial() ) {
		$element->setAttribute( 'disabled', 'disabled' );
	}
	$form_setup[] = $element;

	$um_profile_menu_icon = isset( $buddyform['um_profile_menu_icon'] ) ? $buddyform['um_profile_menu_icon'] : 'um-faicon-pencil';
	$element = new Element_Textbox( "<br><b>" . __( 'Menu Icon', 'buddyforms' ) . "</b>", "buddyforms_options[um_profile_menu_icon]", array( 'value'     => $um_profile_menu_icon,
	                                                                                                                                      'shortDesc' => __( 'Ultimate Member profile menu item. List off all <a href="https://gist.github.com/plusplugins/b504b6851cb3a8a6166585073f3110dd" target="_blank">UM Favicon Icons</a>', 'buddyforms' )
	) );
	if ( buddyforms_um_fs()->is_not_paying() && ! buddyforms_um_fs()->is_trial() ) {
		$element->setAttribute( 'disabled', 'disabled' );
	}
	$form_setup[] = $element;



	$ultimate_members_moderation_integration = isset( $buddyform['ultimate_members_moderation_integration'] ) ? $buddyform['ultimate_members_moderation_integration'] : '';
	$form_setup[] = new Element_Checkbox( "<b>" . __( 'Add Moderation Tab to the Profile', 'buddyforms' ) . "</b>", "buddyforms_options[ultimate_members_moderation_integration]", array( "integrate" => "Display Moderation Tab" ), array(
		'value'     => $ultimate_members_moderation_integration,
		'shortDesc' => __( 'You need the Moderation Extension for ths option to take effect. You can get it from <a target="_blank" href="https://themekraft.com/products/moderation/"> here!</a>', 'buddyforms' )
	) );


	$ultimate_members_cpublisching_moderation_integration = isset( $buddyform['ultimate_members_cpublisching_moderation_integration'] ) ? $buddyform['ultimate_members_cpublisching_moderation_integration'] : '';
	$form_setup[] = new Element_Checkbox( "<b>" . __( 'Add Collaborative Posts Tab to the Profile', 'buddyforms' ) . "</b>", "buddyforms_options[ultimate_members_cpublisching_moderation_integration]", array( "integrate" => "Display Collaborative Publishing Tab" ), array(
		'value'     => $ultimate_members_cpublisching_moderation_integration,
		'shortDesc' => __( 'You need the Collaborative Publishing Extension for ths option to take effect. You can get it from <a target="_blank" href="https://themekraft.com/products/collaburative-publishing/"> here!</a>', 'buddyforms' )
	) );





	buddyforms_display_field_group_table( $form_setup );

}

add_filter( 'add_meta_boxes', 'buddyforms_ultimate_members_admin_settings_sidebar_metabox' );
