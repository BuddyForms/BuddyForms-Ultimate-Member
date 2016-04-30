<?php

/*
 Plugin Name: BuddyForms Ultimate Member
 Plugin URI: http://buddyforms.com/downloads/buddyforms-ultimatemember/
 Description: UltimateMember Integration
 Version: 0.1
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

 add_action('init', 'buddyforms_ultimate_members_init', 1999999999);

function buddyforms_ultimate_members_init(){
  if( ! defined( 'BUDDYFORMS_VERSION' )){
     add_action( 'admin_notices', create_function( '', 'printf(\'<div id="message" class="error"><p><strong>\' . __(\'BuddyForms Ultimate Members needs BuddyForms to be installed. <a target="_blank" href="%s">--> Get it now</a>!\', " buddyforms" ) . \'</strong></p></div>\', "http://themekraft.com/store/wordpress-front-end-editor-and-form-builder-buddyforms/" );' ) );
     return;
   }
   if( ! class_exists('UM_API')){
     add_action( 'admin_notices', create_function( '', 'printf(\'<div id="message" class="error"><p><strong>\' . __(\'BuddyForms Ultimate Members needs Ultimate Members to be installed. <a target="_blank" href="%s">--> Get it now</a>!\', " buddyforms" ) . \'</strong></p></div>\', "https://ultimatemember.com/" );' ) );
     return;
   }

  require (dirname(__FILE__) . '/includes/form-builder.php');
  require (dirname(__FILE__) . '/includes/functions.php');
  require (dirname(__FILE__) . '/includes/redirect.php');
  require (dirname(__FILE__) . '/includes/ultimate-member-extension.php');
}
