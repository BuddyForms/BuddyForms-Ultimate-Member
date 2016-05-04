<?php

// Add a custom tabs to the profile
add_filter('um_profile_tabs', 'bf_profile_tabs', 1000 );
function bf_profile_tabs( $tabs ) {
  global $buddyforms;

  // run thrue all forms and check if they should get integrated
  if(isset($buddyforms) && is_array($buddyforms)) : foreach($buddyforms as $form_slug => $form) :
    if(isset($form['ultimate_members_profiles_integration'])){

      // Set the Tap slug
      $parent_tab_slug = bf_ultimate_member_parent_tab($form);

      // Set the Tab name
      $parent_tab_name = $form['name'];

      // Check if the form has a parent tap and use the parent tab name instad the from name
      if (isset($form['ultimate_members_profiles_integration'])
          && isset($form['ultimate_members_profiles_parent_tab'])){
        $attached_page = $form['attached_page'];
        $parent_tab_page = get_post($attached_page, 'OBJECT');
        $parent_tab_name = $parent_tab_page->post_title;
      }

      // Check if this form is grouped under a Parent Tap and only create the nav item once
      if( ! isset($tabs[$parent_tab_slug] )){
        $tabs[$parent_tab_slug] = array(
            'name' => $parent_tab_name ,
            'icon' => 'um-faicon-pencil',
            'custom' => true
        );
        $tabs[$parent_tab_slug]['subnav_default'] = 'posts-' . $form_slug;
        add_action('um_profile_content_' . $parent_tab_slug . '_default' , create_function('$form_slug', 'bf_profile_tabs_content('.$form_slug.');'));
      }

      // Add the Subtabs to the Ultimate Member Menue
      $tabs[$parent_tab_slug]['subnav']['posts-' . $form_slug] = __('View ' . $form['singular_name'],'buddyforms');

      // Add the Subtab for the create only if diplayd profil is from loged in user.
      if(um_is_user_himself()){
        // Check if the user has the needed rights
  			if (current_user_can('buddyforms_' . $form_slug . '_create')) {
          $tabs[$parent_tab_slug]['subnav']['form-' . $form_slug] = __('Create ' . $form['singular_name'],'buddyforms');
        }
      }

      // Hook the content into the coret tabs
      add_action('um_profile_content_' . $parent_tab_slug . '_posts-' . $form_slug, create_function('$form_slug', 'bf_profile_tabs_content('.$form_slug.');'));
      add_action('um_profile_content_' . $parent_tab_slug . '_form-' . $form_slug, create_function('$form_slug', 'bf_profile_tabs_content('.$form_slug.');'));

    }
  endforeach; endif;
  return $tabs;
}

//
// Display the Tab Content
//
function bf_profile_tabs_content($form_slug){
  global $buddyforms;

  // Get the correct tab slug
	$parent_tab = bf_ultimate_member_parent_tab($buddyforms[$form_slug]);

  // Check if the ultimate member view is a form view and add the coret content
  if(isset($_GET['profiletab']) && $_GET['profiletab'] == $parent_tab ){
    if(!isset($_GET['subnav']) || $_GET['subnav'] == 'posts-' . $form_slug)  {

      // Display the posts
      echo do_shortcode('[buddyforms_the_loop form_slug="'.$form_slug.'"]');

    } else {

      // Create the arguments aray for the form to get displayed
      $args = array(
        'form_slug' => $form_slug
      );

      // Add the post ide if post edit
      if(isset($_GET['bf_post_id']))
        $args['post_id'] = $_GET['bf_post_id'];

      // Add the revisionsid if needed
      if(isset($_GET['bf_rev_id']))
        $args['revision_id'] = $_GET['bf_rev_id'];

      buddyforms_create_edit_form($args);
    }
  }
}
