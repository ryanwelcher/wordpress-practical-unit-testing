<?php

namespace tenup\demo;

/**
 * setup the actions
 */
function init_actions() {
	add_action( 'init', '\tenup\demo\action_register_cpt' );
}

/**
 * Callback to register the CPT
 */
function action_register_cpt() {

	$args = array(
		'public' => true,
		'label'  => 'Staff',
	);
	register_post_type( 'staff', $args );
}


/**
 * Confirm that a new email is both valid and not already in a list of known email addresses.
 *
 * @param string $new_email           The new email we're going to add.
 * @param array $list_of_saved_emails The list of currently saved emails to check against.
 *
 * @return bool
 */
function is_new_and_valid_email( $new_email, $list_of_saved_emails ) {

	if ( ! filter_var( $new_email, FILTER_VALIDATE_EMAIL ) ) {
		return false;
	}

	if ( in_array( $new_email, $list_of_saved_emails, true ) ) {
		return false;
	}

	return true;
}


/**
 * Return the list of emails for a given staff member
 *
 * @param $post_id
 *
 * @return array|bool
 */
function get_staff_email_list( $post_id ) {
	$rtn = false;
	$email_list = get_post_meta( absint( $post_id ), 'email_list', true );

	if ( $email_list && ! empty( $email_list ) ) {
		$rtn = $email_list;
	}

	return $rtn;
}



/**
 * Get the list of default staff details that can be saved
 * @return mixed|void
 */
function get_staff_details_list() {

	$details = array(
		'email',
		'phone',
		'ext',
	);

	return apply_filters( 'filter_staff_details_list' , $details );
}


/**
 * Output a list of staff with an action
 */
function generate_staff_list() {
	ob_start();
	do_action( 'above_staff_list' );
	echo 'MARKUP';
	return ob_end_clean();
}

/**
 * Output the avatar with an action to add more things
 */
function generate_staff_avatar( $post_id ) {
	ob_start();
	do_action( 'above_staff_avatar', $post_id );
	echo 'MARKUP';
	return ob_end_clean();
}
