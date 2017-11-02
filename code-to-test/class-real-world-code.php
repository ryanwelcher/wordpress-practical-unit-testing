<?php

/**
 * Class Real_World_Class
 *
 * A class that might be seen in the wild
 */
class Real_World_Class {
	/**
	 * @var string $_cpt The name of the custom post type.
	 */
	protected $_cpt = 'custom-thing';


	/**
	 * @var string $_template_key Custom meta key for a stored component template.
	 */
	protected $_template_key = 'component-layout';


	/**
	 * Real_World_Class constructor.
	 *
	 * Hard to test these - how can we be sure they are added
	 */
	function __construct() {
		add_action( 'init', array( $this, 'action_init' ) );
		add_action( 'save_post', array( $this, 'action_save_post' ) );
	}


	/**
	 * Nothing is returned - not really testable
	 */
	function action_init() {
		register_post_type( $this->_cpt, array( 'label' => 'Custom', 'public' => true ) );
	}


	/**
	 * Calling a method from another namespace and uses an external class
	 */
	function generate_admin_message( $message ) {

		$success = \fake\name\space\admin_message( $message );

		if ( ! is_wp_error( $success ) ) {
			return true;
		} else {
			return $success->get_error_message();
		}
	}




	/**
	 * Hard to test this - nothing gets returned
	 * @param $post_id
	 */
	function action_save_post( $post_id ) {

		if ( defined( 'DOING_AUTOSAVE' ) && true === DOING_AUTOSAVE ) {
			return;
		}

		if ( ! current_user_can( 'edit_post' ) ) {
			return;
		}

		if ( isset( $_POST['data'] ) ) {
			$value = sanitize_text_field( $_POST['data'] );
			update_post_meta( $post_id, 'meta-name', $value );
		}
	}


	/**
	 * Get the path to the template path we want to use
	 *
	 * @since 0.1.0
	 *
	 * @param int $item_id
	 *
	 * @return string The path to the template file
	 */
	function get_component_presentation_template_path( $item_id ) {

		//allow overriding of template path
		$override_path = apply_filters( 'component_template', false );

		if ( $override_path  ) {
			return $override_path;
		}

		$base_path = __DIR__ . '/template-parts/views%s.php';
		$style     = ( $s = get_post_meta( $item_id, $this->_template_key, true ) ) ? '-'. $s : '';
		$template_path = sprintf( $base_path, $style );

		return $template_path;

	}
}


/**
 * This helper function is not stored in this file but is used here ...
 */
init_class( '\tenup\demo\Real_World_Class' );
