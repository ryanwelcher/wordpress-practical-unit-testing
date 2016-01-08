<?php

/**
 * Mocking out this method
 */




namespace {
	/**
	 * Class Real_World_Tests
	 *
	 * @group real-world
	 */
	class Real_World_Tests extends PHPUnit_Framework_TestCase {


		protected $instance;

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
		 * This is INSANE - don't put your actions in a constructor.
		 */
		function test_actions_added_in_constructor() {
			$class  = new \ReflectionClass( '\tenup\demo\Real_World_Class' );
			$object = $class->newInstanceWithoutConstructor();
			\WP_Mock::expectActionAdded( 'init', [ $object, 'action_init' ] );
			$object->__construct();
		}

		/**
		 * Testing the post meta save
		 */
		function test_save_post() {

			$this->instance = new tenup\demo\Real_World_Class();

			//Fake the post data
			$_POST = array(
				'data' => 'meta-value',
			);

			\WP_Mock::wpFunction( 'current_user_can', array(
				'times'  => 1,
				'args'   => array( 'edit_post' ),
				'return' => true,
			) );

			\WP_Mock::wpFunction( 'sanitize_text_field', array(
				'times'  => 1,
				'args'   => array( \WP_Mock\Functions::type( 'string' ) ),
				'return' => 'meta-value',
			) );

			\WP_Mock::wpFunction( 'update_post_meta', array(
				'times'  => 1,
				'args'   => array( \WP_Mock\Functions::type( 'int' ), 'meta-name', \WP_Mock\Functions::type( 'string' ) ),
				'return' => true,
			) );

			$actual_results = $this->instance->action_save_post( 12345 );

			// Successfully update should return true.
			//$this->assertTrue( $actual_results );
		}


		/**
		 * Test the results of an external call wrapped in to this class
		 *
		 * @dataProvider data_generate_admin_message
		 */
		function test_generate_admin_message( $is_wp_error, $expected_results, $passed_data ) {

			\WP_Mock::wpFunction( 'is_wp_error', array(
				'times'  => 1,
				'return' => $is_wp_error,
			));

			$this->instance = new tenup\demo\Real_World_Class();
			$this->assertSame( $expected_results, $this->instance->generate_admin_message( $passed_data ) );
		}


		function data_generate_admin_message() {
			return array(
				array(
					true,
					'Error Happened',
					12345,
				),
				array(
					false,
					true,
					'Message',
				),
			);
		}
	}
}