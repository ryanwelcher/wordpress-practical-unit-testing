<?php
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