<?php

/**
 * Confirm that a new email is both valid and not already in a list of known email addresses.
 *
 * @param string        $new_email     The new email we're checking
 * @param \EmailManager $manager_class An instance of an email manager class.
 *
 * @return bool
 */
function is_new_and_valid_email( $new_email, $manager_class ) {
	
	$list_of_saved_emails = $manager_class->get_known_list();
	
	if ( ! filter_var( $new_email, FILTER_VALIDATE_EMAIL ) ) {
		return false;
	}
	
	if ( in_array( $new_email, $list_of_saved_emails, true ) ) {
		return false;
	}
	
	return true;
}


/**
 * Wrapper method to insert a new email.
 *
 * @param string       $new_email     The email we want to add.
 * @param EmailManager $manager_class An instance of an email manager class.
 *
 * @return bool
 */
function add_new_email_address( $new_email, $manager_class ) {
	if ( ! empty( $new_email ) ) {
		return $manager_class->add_address( $new_email );
	}
	return false;
}