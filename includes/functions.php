<?php

//
// Load all needed css and js
// @todo: this should not be global.
//
function bf_um_front_js_css_loader($fount){
    return true;
}
add_filter('buddyforms_front_js_css_loader', 'bf_um_front_js_css_loader', 10, 1 );

//
// Helper function to get the parent slug for the profil navigation
// Coppy of function rewrite_rules /ultimate-member/core/um-rewrite.php line 31
// @todo: crearte a pull request to fire the rewrire function if set to not load automaticaly...?!

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


//
// This function is a workaround for ultimate member to avoid 404 issues....
//
function buddyforms_ultimate_member_after_attache_page_rewrite_rules($flush_rewrite_rules){

if(!$flush_rewrite_rules)
  return;

  global $ultimatemember;

  if ( isset( $ultimatemember->permalinks->core['user'] )  ) {

    $user_page_id = $ultimatemember->permalinks->core['user'];
    $account_page_id = $ultimatemember->permalinks->core['account'];
    $user = get_post($user_page_id);

    if ( isset( $user->post_name ) ) {

      $user_slug = $user->post_name;
      $account = get_post($account_page_id);
      $account_slug = $account->post_name;

      $add_lang_code = '';

      if ( function_exists('icl_object_id') || function_exists('icl_get_current_language')  ) {

        if( function_exists('icl_get_current_language') ){
          $language_code = icl_get_current_language();
        }else if( function_exists('icl_object_id') ){
          $language_code = ICL_LANGUAGE_CODE;
        }

        // User page translated slug
        $lang_post_id = icl_object_id( $user->ID, 'post', FALSE, $language_code );
        $lang_post_obj = get_post( $lang_post_id );
        if( isset( $lang_post_obj->post_name ) ){
          $user_slug = $lang_post_obj->post_name;
        }

        // Account page translated slug
        $lang_post_id = icl_object_id( $account->ID, 'post', FALSE, $language_code );
        $lang_post_obj = get_post( $lang_post_id );
        if( isset( $lang_post_obj->post_name ) ){
          $account_slug = $lang_post_obj->post_name;
        }

        if(  $language_code != icl_get_default_language() ){
          $add_lang_code = $language_code;
        }

      }

      add_rewrite_rule( $user_slug.'/([^/]+)/?$',
                'index.php?page_id='.$user_page_id.'&um_user=$matches[1]&lang='.$add_lang_code,
                'top'
      );

      add_rewrite_rule( $account_slug.'/([^/]+)?$',
                'index.php?page_id='.$account_page_id.'&um_tab=$matches[1]&lang='.$add_lang_code,
                'top'
      );


      flush_rewrite_rules( true );

    }

  }

}
//add_action('buddyforms_after_attache_page_rewrite_rules', 'buddyforms_ultimate_member_after_attache_page_rewrite_rules', 199999999, 1);
