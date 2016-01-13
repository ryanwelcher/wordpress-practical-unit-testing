<?php

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
		$this->instance = new tenup\demo\Real_World_Class();
	}

	/**
	 * Clean up after the test is run
	 */
	function tearDown() {
		\WP_Mock::tearDown();
		unset( $this->instance );
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
	 * Let's test to be sure the function is called.
	 */
	function test_action_init() {
		\WP_Mock::wpPassthruFunction( 'register_post_type' );
		$this->instance->action_init();

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

		$this->assertSame( $expected_results, $this->instance->generate_admin_message( $passed_data ) );
	}


	/**
	 * Data provider.
	 *
	 * @return array {
	 *     @type array {
	 *         @type bool  $is_wp_error.
	 *         @type mixed $expected_results
	 *         @type mixed $passd_data.
	 *     }
	 * }
	 */
	function data_generate_admin_message() {
		return array(
			// is_wp_error == true;
			array(
				true,
				'Error Happened',
				12345,
			),

			// is_wp_error == false
			array(
				false,
				true,
				'Message',
			),
		);
	}


	/**
	 * Testing the post meta save by checking that all of the the methods are being called.
	 *
	 * If WP_Mock doesn't complain then then the test passes.
	 */
	function test_save_post() {

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

		$this->instance->action_save_post( 12345 );
	}


	/**
	 * Testing the return component path without filtering
	 *
	 * @dataProvider data_get_component_presentation_template_path
	 */
	function test_get_component_presentation_template_path( $get_post_meta_returns, $expected_filename ) {

		// Mock up the get_post_meta call
		\WP_Mock::wpFunction( 'get_post_meta', array(
			'times' => 1,
			'return' => $get_post_meta_returns,
		));


		$actual_path   = $this->instance->get_component_presentation_template_path( 1337 );

		$this->assertSame( $expected_filename, basename( $actual_path ) );
	}

	/**
	 * Data provider.
	 *
	 * @return array {
	 *     @type array {
	 *         @type bool   $get_post_meta_returns.
	 *         @type string $expected_filename
	 *     }
	 * }
	 */
	function data_get_component_presentation_template_path() {
		return array(
			array(
				'my-test',
				'views-my-test.php',
			),
			array(
				false,
				'views.php',
			),
		);
	}

	/**
	 * Test the filter override for the same method
	 */
	function test_filters_get_component_presentation_template_path() {

		\WP_Mock::onFilter( 'component_template' )
		        ->with( false )
		        ->reply( 'custom-template.php' );

		$actual = $this->instance->get_component_presentation_template_path( 1337 );

		$this->assertSame( 'custom-template.php', $actual );

	}
}
