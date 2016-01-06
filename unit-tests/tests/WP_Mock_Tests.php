<?php
/**
 * Class WP_Mock_Tests
 *
 * @group wp-mock
 */
class WP_Mock_Tests extends PHPUnit_Framework_TestCase {


	/**
	 * Setup WP_Mock for each test
	 */
	function setUp() {
		\WP_Mock::setUp();
	}

	/**
	 * Clean up after the test is run
	 */
	function tearDown() {
		\WP_Mock::tearDown();
	}

	/**
	 * Simple test to be sure that our plugin is adding the actions as expected
	 */
	function test_init_actions() {

		\WP_Mock::expectActionAdded( 'init', '\tenup\demo\action_register_cpt' );

		//call the method that adds the actions we're expecting
		\tenup\demo\init_actions();
	}


	/**
	 *
	 */
	function test_registering_the_cpt() {

		\WP_Mock::wpFunction( 'register_post_type', array(
			'times' => 1,
			'args'  => array( 'staff', array( 'public' => true, 'label' => 'Staff' ) ),
		) );

		\tenup\demo\action_register_cpt();
	}


	/**
	 * The get_staff_email_list function uses WP items so
	 * we need to setup passthru methods using WP_Mock in order test it
	 */
	function test_get_staff_email_list() {


		// Our function calls this 1 time, with the arguments list below  and returns th
		\WP_Mock::wpFunction( 'get_post_meta', array(
			'times' => 1,
			'args'  => array( \WP_Mock\Functions::type( 'int' ), 'email_list', true ),
			'return' => array( 'email1@email.com' ),
		));


		\WP_Mock::wpFunction( 'absint', array(
			'times' => 1,
			'args' => array( '*' ),
			'return' => 1,
		));

		$results = \tenup\demo\get_staff_email_list( 1 );

		//assert the type
		$this->assertSame( 'array', gettype( $results ) );

		//assert that the array has the email in it.
		$this->assertContains( 'email1@email.com', $results );
	}
}

