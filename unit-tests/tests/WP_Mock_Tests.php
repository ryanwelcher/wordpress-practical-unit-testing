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
	 * Testing to be sure the the method was called
	 *
	 * In this case we don't really care what was returned, just that it was called
	 */
	function test_registering_the_cpt() {

		\WP_Mock::wpPassthruFunction( 'register_post_type' );

		\tenup\demo\action_register_cpt();
	}



	/**
	 * The get_staff_email_list function uses WP core functions so
	 * we need to setup pass through methods using WP_Mock in order test it
	 */
	function test_get_staff_email_list() {

		\WP_Mock::wpFunction( 'get_post_meta', array(
			'times'  => 1, // How many times this method is called by the function we're testing.
			'args'   => array( \WP_Mock\Functions::type( 'int' ), 'email_list', true ), // Args being passed to the function, WP_Mock allows for type checking.
			'return' => array( 'email1@email.com' ), // The data that we are passing through the function
		));

		// We use absint so we have to mock it as well
		\WP_Mock::wpFunction( 'absint', array(
			'times' => 1,
			'args' => array( '*' ), // This means the arg can be anything - useful when testing bad data.
			'return' => 1,
		));

		//now we can call the method with a dummy value.
		$results = \tenup\demo\get_staff_email_list( 1 );

		//now that we have the data that we need, we can do any assertions

		//assert the type
		$this->assertSame( 'array', gettype( $results ) );

		//assert that the array has the email in it.
		$this->assertContains( 'email1@email.com', $results );
	}



	/**
	 * Testing a custom filter
	 */
	function test_filtering_staff_details_list() {

		$filtered_array = array(
			'email',
			'phone',
			'ext',
			'coffee type',
		);

		\WP_Mock::onFilter( 'filter_staff_details_list' )
			->with( array( 'email', 'phone', 'ext' ) ) //this is the data being passed to the filter
			->reply( $filtered_array );

		$details = \tenup\demo\get_staff_details_list();

		$this->assertSame( $filtered_array, $details );
	}


	/**
	 * Testing a custom action.
	 */
	function test_custom_action() {

		\WP_Mock::expectAction( 'above_staff_list' );

		\tenup\demo\generate_staff_list();
	}

	/**
	 * Testing a custom action that has a parameter
	 */
	function test_custom_action_with_params() {

		\WP_Mock::expectAction( 'above_staff_avatar', 12345 );

		\tenup\demo\generate_staff_avatar( 12345 );
	}


	/**
	 * Testing that the returned markup is the same.
	 */
	function test_generate_staff_list_markup() {
		$this->assertSame( '<h1>rage MARKUP!</h1>', \tenup\demo\generate_staff_list() );
	}
}

