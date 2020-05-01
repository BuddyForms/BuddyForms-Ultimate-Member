<?php

function buddyforms_ultimate_members_admin_tab( $tabs ) {
	if ( ! defined( 'BUDDYFORMS_ULTIMATE_MEMBER_ASSETS' ) ) {
		return $tabs;
	}

	$tabs['buddyforms_ultimate_member'] = 'Ultimate Member';

	return $tabs;
}

add_filter( 'buddyforms_admin_tabs', 'buddyforms_ultimate_members_admin_tab', 1, 1 );

function buddyforms_ultimate_members_admin_tab_page( $tab ) {
	if ( $tab != 'buddyforms_ultimate_member' ) {
		return;
	}

	if ( ! defined( 'BUDDYFORMS_ULTIMATE_MEMBER_ASSETS' ) ) {
		return;
	}

	$ultimate_members_settings = get_option( 'buddyforms_ultimate_settings' );

	$options = array(
		'deactivate' => __( 'Deactivate', 'buddyforms-ultimate-member' ),
		'activate'   => __( 'Activate', 'buddyforms-ultimate-member' )
	);
	$privacy = array(
		3 => __( 'Force to `Only the owner`', 'buddyforms-ultimate-member' ),
		5 => __( 'Define in Moderation', 'buddyforms-ultimate-member' ),
	);

	if ( ! isset( $ultimate_members_settings['moderation_tab_privacy'] ) ) {
		$ultimate_members_settings['moderation_tab_privacy'] = 3;
	}

	if ( ! isset( $ultimate_members_settings['collaborative_post_tab_privacy'] ) ) {
		$ultimate_members_settings['collaborative_post_tab_privacy'] = 3;
	}

	if ( empty( $ultimate_members_settings['moderation_tab_name'] ) ) {
		$ultimate_members_settings['moderation_tab_name'] = apply_filters( 'buddyforms_ultimate_member_moderation_tab_title', __( 'Moderate Posts', 'buddyforms-ultimate-member' ) );
	}
	if ( empty( $ultimate_members_settings['collaborative_post_tab_name'] ) ) {
		$ultimate_members_settings['collaborative_post_tab_name'] = apply_filters( 'buddyforms_ultimate_member_collaborative_tab_title', __( 'Collaborative Posts', 'buddyforms-ultimate-member' ) );
	}

	?>

	<div class="metabox-holder">
		<div class="postbox buddyforms-metabox">
			<div class="inside">
				<form method="post" action="options.php">
					<?php settings_fields( 'buddyforms_ultimate_settings' ); ?>
					<fieldset>
						<table class="form-table">
							<tbody>
							<tr>
								<th colspan="2">
									<h1><span><?php _e( 'Global options related to BuddyForms Ultimate Member', 'buddyforms-ultimate-member' ); ?></span></h1>
								</th>
							</tr>
							<tr>
								<th colspan="2">
									<h3><span><?php _e( 'BuddyForms Moderation', 'buddyforms-ultimate-member' ); ?></span></h3>
									<hr/>
									<small><?php _e( 'You need the Moderation Extension for ths option to take effect. You can get it from <a target="_blank" href="https://themekraft.com/products/moderation/"> here!</a>', 'buddyforms-ultimate-member' ) ?></small>
								</th>
							</tr>
							<tr valign="top">
								<th scope="row" class="titledesc">
									<label for="buddyforms_ultimate_settings_moderation_tab"><?php _e( 'Add Moderation Tab', 'buddyforms-ultimate-member' ); ?></label>
								</th>
								<td class="forminp forminp-select">
									<select name="buddyforms_ultimate_settings[moderation_tab]" id="buddyforms_ultimate_settings_moderation_tab">
										<?php foreach ( $options as $item_key => $item_name ) : ?>
											<option value="<?php echo $item_key ?>" <?php selected( $item_key, $ultimate_members_settings['moderation_tab'] ); ?> ><?php echo $item_name ?></option>
										<?php endforeach; ?>
									</select>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row" class="titledesc">
									<label for="buddyforms_ultimate_settings_moderation_tab_name"><?php _e( 'Moderation Tab Title', 'buddyforms-ultimate-member' ); ?></label>
								</th>
								<td class="forminp forminp-select">
									<input type="text" style="max-width: 25rem" name="buddyforms_ultimate_settings[moderation_tab_name]" id="buddyforms_ultimate_settings_moderation_tab_name" value="<?php echo esc_attr( $ultimate_members_settings['moderation_tab_name'] ) ?>">
								</td>
							</tr>
							<tr valign="top">
								<th scope="row" class="titledesc">
									<label for="buddyforms_ultimate_settings_moderation_tab_privacy"><?php _e( 'Moderation Tab Privacy', 'buddyforms-ultimate-member' ); ?></label>
								</th>
								<td class="forminp forminp-select">
									<select name="buddyforms_ultimate_settings[moderation_tab_privacy]" id="buddyforms_ultimate_settings_moderation_tab_privacy">
										<?php foreach ( $privacy as $privacy_key => $privacy_name ) : ?>
											<option value="<?php echo $privacy_key ?>" <?php selected( $privacy_key, $ultimate_members_settings['moderation_tab_privacy'] ); ?> ><?php echo $privacy_name ?></option>
										<?php endforeach; ?>
									</select>
									<br/>
									<small><?php echo sprintf( __( 'For more privacy option check inside the UM Profile Member <a target="_blank" href="%s">here!</a>', 'buddyforms-ultimate-member' ), get_admin_url( get_current_blog_id(), 'admin.php?page=um_options&tab=appearance&section=profile_menu' ) ) ?></small>
								</td>
							</tr>

							<tr>
								<th colspan="2">
									<h3><span><?php _e( 'BuddyForms Collaborative', 'buddyforms-ultimate-member' ); ?></span></h3>
									<hr/>
									<small><?php _e( 'You need the Collaborative Publishing Extension for ths option to take effect.', 'buddyforms-ultimate-member' ); ?></small>
								</th>
							</tr>
							<tr valign="top">
								<th scope="row" class="titledesc">
									<label for="buddyforms_ultimate_settings_collaborative_post_tab"><?php _e( 'Add Collaborative Posts Tab', 'buddyforms-ultimate-member' ); ?></label>
								</th>
								<td class="forminp forminp-select">
									<select name="buddyforms_ultimate_settings[collaborative_post_tab]" id="buddyforms_ultimate_settings_collaborative_post_tab">
										<?php foreach ( $options as $item_key => $item_name ) : ?>
											<option value="<?php echo $item_key ?>" <?php selected( $item_key, $ultimate_members_settings['collaborative_post_tab'] ); ?> ><?php echo $item_name ?></option>
										<?php endforeach; ?>
									</select>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row" class="titledesc">
									<label for="buddyforms_ultimate_settings_moderation_tab_name"><?php _e( 'Collaborative Tab Title', 'buddyforms-ultimate-member' ); ?></label>
								</th>
								<td class="forminp forminp-select">
									<input type="text" style="max-width: 25rem" name="buddyforms_ultimate_settings[collaborative_post_tab_name]" id="buddyforms_ultimate_settings_moderation_tab_name" value="<?php echo esc_attr( $ultimate_members_settings['collaborative_post_tab_name'] ) ?>">
								</td>
							</tr>
							<tr valign="top">
								<th scope="row" class="titledesc">
									<label for="buddyforms_ultimate_settings_moderation_tab_privacy"><?php _e( 'Collaborative Tab Privacy', 'buddyforms-ultimate-member' ); ?></label>
								</th>
								<td class="forminp forminp-select">
									<select name="buddyforms_ultimate_settings[collaborative_post_tab_privacy]" id="buddyforms_ultimate_settings_moderation_tab_privacy">
										<?php foreach ( $privacy as $privacy_key => $privacy_name ) : ?>
											<option value="<?php echo $privacy_key ?>" <?php selected( $privacy_key, $ultimate_members_settings['collaborative_post_tab_privacy'] ); ?> ><?php echo $privacy_name ?></option>
										<?php endforeach; ?>
									</select>
									<br/>
									<small><?php echo sprintf( __( 'For more privacy option check inside the UM Profile Member <a target="_blank" href="%s">here!</a>', 'buddyforms-ultimate-member' ), get_admin_url( get_current_blog_id(), 'admin.php?page=um_options&tab=appearance&section=profile_menu' ) ) ?></small>
								</td>
							</tr>

							</tbody>
						</table>
					</fieldset>
					<?php submit_button(); ?>

				</form>
			</div><!-- .inside -->
		</div><!-- .postbox -->
	</div><!-- .metabox-holder -->
	<?php
}

add_action( 'buddyforms_settings_page_tab', 'buddyforms_ultimate_members_admin_tab_page' );

function buddyforms_ultimate_register_option() {
	// creates our settings in the options table
	register_setting( 'buddyforms_ultimate_settings', 'buddyforms_ultimate_settings', 'buddyforms_ultimate_settings_default_sanitize' );
}

add_action( 'admin_init', 'buddyforms_ultimate_register_option' );

// Sanitize the Settings
function buddyforms_ultimate_settings_default_sanitize( $new ) {
	return $new;
}