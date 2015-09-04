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

/* add a custom tab to show user pages */
add_filter('um_profile_tabs', 'bf_pages_tab', 1000 );
function bf_pages_tab( $tabs ) {
    $tabs['pages'] = array(
        'name' => 'Pages',
        'icon' => 'um-faicon-pencil',
        'count' => 0,
        'custom' => true
    );
    return $tabs;
}

/* Tell the tab what to display */
add_action('um_profile_content_pages_default', 'bf_um_profile_form');
function bf_um_profile_form( $args ) {
    global $ultimatemember;
    echo do_shortcode('[buddyforms_form form_slug="tests"]');
}