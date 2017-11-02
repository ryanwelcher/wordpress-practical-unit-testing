<?php

/**
 * Global namespace things
 */
namespace {
	/**
	 * We need to mock this out so we can load the real world class and not fatal out.
	 */
	function init_class( $class ) {
		return;
	}

	/**
	 * Class WP_Error
	 *
	 * This is a mock of of only the items we need to complete the tests.
	 */
	class WP_Error {

		protected $_code;
		protected $_message;
		protected $_data;

		function __construct( $code = '', $message = '', $data = '' ) {

			$this->_code    = $code;
			$this->_message = $message;
			$this->_data    = $data;
		}

		function get_error_message() {
			return $this->_message;
		}
	}
}

/**
 * other namespaces
 */
namespace fake\name\space {
	/**
	 * @param $message
	 *
	 * @return \WP_Error
	 */
	function admin_message( $message ) {
		if ( ! empty( $message ) && 'string' === gettype( $message ) ) {
			return $message;
		} else {
			return new \WP_Error( 1234, 'Error Happened', '' );
		}
	}
}