<?php

/*
 Plugin Name: BuddyForms Ultimate Member
 Plugin URI: http://buddyforms.com/downloads/buddyforms-ultimatemember/
 Description: UltimateMember Integration
 Version: 1.0
 Author: Sven Lehnert
 Author URI: https://profiles.wordpress.org/svenl77
 License: GPLv2 or later
 Network: false

 *****************************************************************************
 *
 * This script is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 ****************************************************************************
 */

// Create the Form Builder Sidebar Metabox
 function buddyforms_ultimate_members_admin_settings_sidebar_metabox(){
     add_meta_box('buddyforms_ultimate_members', __("Ultimate Members",'buddyforms'), 'buddyforms_ultimate_members_admin_settings_sidebar_metabox_html', 'buddyforms', 'side', 'low');
 }

// Form Builder Sidebar Metabox Content
 function buddyforms_ultimate_members_admin_settings_sidebar_metabox_html(){
     global $post, $buddyforms;

     if($post->post_type != 'buddyforms')
         return;

     $buddyform = get_post_meta(get_the_ID(), '_buddyforms_options', true);
     $form_setup = array();

     $ultimate_members_profiles_integration = '';
     if(isset($buddyform['ultimate_members_profiles_integration']))
         $ultimate_members_profiles_integration = $buddyform['ultimate_members_profiles_integration'];

     $ultimate_members_profiles_parent_tab = false;
     if(isset($buddyform['ultimate_members_profiles_parent_tab']))
         $ultimate_members_profiles_parent_tab = $buddyform['ultimate_members_profiles_parent_tab'];

     $form_setup[] = new Element_Checkbox("<b>" . __('Add this form as Profile Tab', 'buddyforms') . "</b>", "buddyforms_options[ultimate_members_profiles_integration]", array("integrate" => "Integrate this Form"), array('value' => $ultimate_members_profiles_integration, 'shortDesc' => __('Many forms can share the same attached page. All Forms with the same attached page can be grouped together with this option. All Forms will be listed as sub nav tabs of the page main nav', 'buddyforms')));
     $form_setup[] = new Element_Checkbox("<br><b>" . __('Use Attached Page as Parent Tab and make this form a sub tab of the parent', 'buddyforms') . "</b>", "buddyforms_options[ultimate_members_profiles_parent_tab]", array("attached_page" => "Use Attached Page as Parent"), array('value' => $ultimate_members_profiles_parent_tab, 'shortDesc' => __('Many Forms can have the same attached Page. All Forms with the same page with page as parent enabled will be listed as sub forms. This why you can group forms.', 'buddyforms')));
     //$form_setup[] = new Element_Checkbox("<br><b>" . __('Hide Post List', 'buddyforms') . "</b>", "buddyforms_options[profiles_parent_tab]", array("hide" => "Hide"), array('value' => $profiles_parent_tab, 'shortDesc' => __('Can be useful if you want to display all posts in one tab and only separate the forms', 'buddyforms')));

     foreach($form_setup as $key => $field){
         echo '<div class="buddyforms_field_label">' . $field->getLabel() . '</div>';
         echo '<div class="buddyforms_field_description">' . $field->getShortDesc() . '</div>';
         echo '<div class="buddyforms_form_field">' . $field->render() . '</div>';
     }
 }
 add_filter('add_meta_boxes','buddyforms_ultimate_members_admin_settings_sidebar_metabox');


// Add a custom tabs to the profile
add_filter('um_profile_tabs', 'bf_profile_tabs', 1000 );
function bf_profile_tabs( $tabs ) {
  global $buddyforms;

  // run thrue all forms and check if they should get integrated
  if(isset($buddyforms)) : foreach($buddyforms as $form_slug => $form) :
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

      $tabs[$parent_tab_slug]['subnav']['posts-' . $form_slug] = __('View ' . $form['singular_name'],'buddyforms');

      if(um_is_user_himself()){
        // Add the Subtabs to the Ultimate Member Menue
        $tabs[$parent_tab_slug]['subnav']['form-' . $form_slug] = __('Create ' . $form['singular_name'],'buddyforms');
      }

      // echo '<pre>';
      // print_r($tabs);
      // echo '</pre>';

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

echo 'daDADADAda';
print_r($form_slug);

  // Get the correct tab slug
	$parent_tab = bf_ultimate_member_parent_tab($buddyforms[$form_slug]);

  // Check if the ultimate member view is a form view and add the coret content
  if(isset($_GET['profiletab']) && $_GET['profiletab'] == $parent_tab ){
    if(!isset($_GET['subnav']) || $_GET['subnav'] == 'posts-' . $form_slug)  {
      echo do_shortcode('[buddyforms_the_loop form_slug="'.$form_slug.'"]');
    } else {


    $args = array(
      'form_slug' => $form_slug
    );

    if(isset($_GET['bf_post_id']))
      $args['post_id'] = $_GET['bf_post_id'];

    if(isset($_GET['bf_rev_id']))
      $args['revision_id'] = $_GET['bf_rev_id'];

    buddyforms_create_edit_form($args);

      //echo do_shortcode('[buddyforms_form form_slug="'.$form_slug.'"]');
    }
  }
}

//
// Load all needed css and js
// @todo: this should not be global.
//
function bf_um_front_js_css_loader($fount){
    return true;
}
add_filter('buddyforms_front_js_css_loader', 'bf_um_front_js_css_loader', 10, 1 );


//
// Redirect after submit to the correct Ultimate Member Profile Tab
//
function bf_um_after_save_post_redirect($permalink){
  global $buddyforms, $ultimatemember, $post;

  $um_options = get_option('um_options');

  echo $permalink;

  // echo '<pre>';
  // print_r($_POST);
  // echo '</pre>';


  // Check if the form isi submited form within Ultimate Member and do the redirect to the profile is yes.
  if(isset($um_options['core_user']) && $um_options['core_user'] == $post->ID)  {
    //$permalink = get_the_permalink($post->ID) . '?profiletab=product';
  }

  //return $permalink;

}
add_filter('buddyforms_after_save_post_redirect', 'bf_um_after_save_post_redirect', 10 ,1);


/**
 * Redirect the user to their respective profile page
 *
 * @package BuddyForms
 * @since 0.3 beta
 */
function bf_ultimate_member_redirect_to_profile() {
	global $post;

	if( ! isset( $post->ID ) || ! is_user_logged_in() )
		return false;

	$link = bf_ultimate_member_get_redirect_link( $post->ID );

	if( ! empty( $link ) ) :
		wp_safe_redirect( $link );
		exit;
	endif;
}
add_action( 'template_redirect', 'bf_ultimate_member_redirect_to_profile', 999 );

/**
 * Get the redirect link
 *
 * @package BuddyForms
 * @since 0.3 beta
 */
function bf_ultimate_member_get_redirect_link( $id = false ) {
	global $buddyforms, $wp_query, $current_user;

	if( ! $id )
		return false;

  // echo '<pre>';
  // print_r($wp_query->query_vars);
  // echo '</pre>';

	if(!isset( $wp_query->query_vars['bf_form_slug']))
		return false;

	$form_slug = $wp_query->query_vars['bf_form_slug'];

	if(!isset($buddyforms[$form_slug]))
		return false;

	$parent_tab = bf_ultimate_member_parent_tab($buddyforms[$form_slug]);

	$link = '';
	if(isset($buddyforms) && is_array($buddyforms) && isset($parent_tab)){

		if(isset($buddyforms[$form_slug]['attached_page']))
			$attached_page_id = $buddyforms[$form_slug]['attached_page'];

		if(isset($buddyforms[$form_slug]['ultimate_members_profiles_integration']) && isset($attached_page_id) && $attached_page_id == $id){

      $um_options = get_option('um_options');

      $current_user = wp_get_current_user();
      $userdata     = get_userdata($current_user->ID);

			$link = get_the_permalink($um_options['core_user']) . $userdata->user_nicename . '?profiletab=' . $parent_tab;

			if(isset($wp_query->query_vars['bf_action'])){
				if($wp_query->query_vars['bf_action'] == 'create')
					$link = get_the_permalink($um_options['core_user']) . $userdata->user_nicename . '?profiletab=' . $parent_tab . '&subnav=form-' . $form_slug;
				if($wp_query->query_vars['bf_action'] == 'edit')
          $link = get_the_permalink($um_options['core_user']) . $userdata->user_nicename . '?profiletab=' . $parent_tab . '&subnav=form-' . $form_slug . '&bf_post_id=' . $wp_query->query_vars['bf_post_id'];
				if($wp_query->query_vars['bf_action'] == 'revision')
          $link = get_the_permalink($um_options['core_user']) . $userdata->user_nicename . '?profiletab=' . $parent_tab . '&subnav=form-' . $form_slug . '&bf_post_id=' . $wp_query->query_vars['bf_post_id'] . '&bf_rev_id=' . $wp_query->query_vars['bf_rev_id'];
					//$link = bp_loggedin_user_domain() . $parent_tab .'/' . $form_slug . '-revision/'.$bp->unfiltered_uri[3].'/'.$bp->unfiltered_uri[4];
				if($wp_query->query_vars['bf_action'] == 'view')
					$link = get_the_permalink($um_options['core_user']) . $userdata->user_nicename . '?profiletab=' . $parent_tab . '&subnav=posts-' . $form_slug;

			}

		}

	}
	return apply_filters( 'bf_ultimate_member_get_redirect_link', $link );
}






/**
 * Link router function
 *
 * @package BuddyForms
 * @since 0.3 beta
 * @uses	bp_get_option()
 * @uses	is_page()
 * @uses	bp_loggedin_user_domain()
 */
function bf_ultimate_member_page_link_router( $link, $id )	{
	if( ! is_user_logged_in() || is_admin() )
		return $link;

	$new_link = bf_ultimate_member_get_redirect_link( $id );

	if( ! empty( $new_link ) )
		$link = $new_link;

	return apply_filters( 'bf_ultimate_member_page_link_router', $link );
}
add_filter( 'page_link', 'bf_ultimate_member_page_link_router', 10, 2 );

function bf_ultimate_member_page_link_router_edit($link, $id){
	global $buddyforms;

	$form_slug = get_post_meta($id, '_bf_form_slug', true);

	if(!$form_slug)
		return $link;

	if(!$buddyforms[$form_slug]['ultimate_members_profiles_integration'])
		return $link;

	$parent_tab = bf_ultimate_member_parent_tab($buddyforms[$form_slug]);

	return '<a title="Edit" id="' . $id . '" class="bf_edit_post" href="' . bp_loggedin_user_domain()  . $parent_tab. '/'. $form_slug .'-edit/' . $id . '">' . __( 'Edit', 'buddyforms' ) .'</a>';
}
add_filter( 'bf_loop_edit_post_link', 'bf_members_page_link_router_edit', 10, 2 );







// Helper function to get the parent slug for the profil navigation
function bf_ultimate_member_parent_tab($member_form){

	$parent_tab_name = $member_form['slug'];

	if (isset($member_form['ultimate_members_profiles_parent_tab']))
		$parent_tab = $member_form['ultimate_members_profiles_parent_tab'];

	if (isset($member_form['attached_page']) && isset($parent_tab)){
		$attached_page = $member_form['attached_page'];
		$parent_tab_page = get_post($attached_page, 'OBJECT');
		$parent_tab_name = $parent_tab_page->post_name;
	}
	return $parent_tab_name;
}
