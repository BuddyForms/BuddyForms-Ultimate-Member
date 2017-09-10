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


	if ( $buddyform['slug'] == 'posts' && ! empty( $ultimate_members_profiles_integration ) &&
	     $buddyform['slug'] == 'posts' && empty( $ultimate_members_profiles_parent_tab ) ) {
		$message      = __( '<font color="#b22222">This Form is Broken!</font> This form slug is "posts". This slug is reserved for the Ultimate Member Posts Tab. You can only Use Attached Page as Parent Tab and make this form a sub tab of the parent. Please check both options', 'buddyforms' );
		$form_setup[] = new Element_HTML( '<div class="notice notice-error"><p>' . $message . '</p></div><p><b>' . $message . '</b></p>' );
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

	// Loop thrue all form elements and echo the content
	foreach ( $form_setup as $key => $field ) {
		echo '<div class="buddyforms_field_label">' . $field->getLabel() . '</div>';
		echo '<div class="buddyforms_field_description">' . $field->getShortDesc() . '</div>';
		echo '<div class="buddyforms_form_field">' . $field->render() . '</div>';
	}
}

add_filter( 'add_meta_boxes', 'buddyforms_ultimate_members_admin_settings_sidebar_metabox' );
