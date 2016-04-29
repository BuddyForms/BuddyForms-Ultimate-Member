<?php

/*
 Plugin Name: BuddyForms UltimateMember
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
add_filter('um_profile_tabs', 'bf_pages_tab', 1000 );
function bf_pages_tab( $tabs ) {
  global $buddyforms;
  if(isset($buddyforms)) : foreach($buddyforms as $form_slug => $form){
    if(isset($form['ultimate_members_profiles_integration'])){
        $tabs[$form_slug] = array(
            'name' => $form['name'],
            'icon' => 'um-faicon-pencil',
            'subnav' => array(
              'posts' => __('View','buddyforms'),
              'form' => __('Create','buddyforms'),
            ),
            'subnav_default' => 'posts',
            'custom' => true
        );

        // Hook the content into the coret tabs
        add_action('um_profile_content_' . $form_slug . '_default', create_function('$form_slug', 'bf_um_profile_integration('.$form_slug.');'));
        add_action('um_profile_content_' . $form_slug . '_posts', create_function('$form_slug', 'bf_um_profile_integration('.$form_slug.');'));
        add_action('um_profile_content_' . $form_slug . '_form', create_function('$form_slug', 'bf_um_profile_integration('.$form_slug.');'));

      }
    }
  endif;
  return $tabs;
}

//
// Display the Tab Content
//
function bf_um_profile_integration($form_slug){
  // echo '<pre>';
  // print_r($form_slug);
  // echo '</pre>';
  echo 'sadasd'.$_GET['profiletab'];
  if(isset($_GET['profiletab']) && $_GET['profiletab'] == $form_slug ){
    if(isset($_GET['subnav']) && $_GET['subnav'] == 'posts')  {
      echo do_shortcode('[buddyforms_the_loop form_slug="'.$form_slug.'"]');
    } else {
      echo do_shortcode('[buddyforms_form form_slug="'.$form_slug.'"]');
    }
  }
}

function bf_um_front_js_css_loader($fount){
    return true;
}
add_filter('buddyforms_front_js_css_loader', 'bf_um_front_js_css_loader', 10, 1 );


//
// Redirect after submit to the corest Ultimate Member Profile Tab
//
function bf_um_after_save_post_redirect($permalink){
  global $buddyforms, $ultimatemember, $post;

  $um_options = get_option('um_options');

  // print_r($_POST);
  // echo $permalink;

  if(isset($um_options['core_user']) && $um_options['core_user'] == $post->ID)  {
    //$permalink = get_the_permalink($post->ID) . '?profiletab=product';
  }

  return $permalink;

}
add_filter('buddyforms_after_save_post_redirect', 'bf_um_after_save_post_redirect', 10 ,1);
