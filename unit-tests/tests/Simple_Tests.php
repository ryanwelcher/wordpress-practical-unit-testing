<?php
/**
 * Class Simple_Tests
 *
 * Tests that just use PHPUnit
 *
 * @group simple-tests
 */
class Simple_Tests extends PHPUnit_Framework_TestCase {


	/**
	 * This is not recognized as a test and doesn't run - we need to prefix methods with `test_`
	 */
	function no_prefix() {
		$this->assertTrue( false );
	}



	/**
	 * Simple unit test with hardcoded values
	 */
	function test_is_new_and_valid_email_once() {
		$expected_result = true;
		$actual_result   = \tenup\demo\is_new_and_valid_email( 'new@email.com', array( 'alternate@email.com' ) );

		$this->assertSame( $expected_result, $actual_result );
	}

	/**
	 * Simple unit test with a dataprovider so we can run many assertions in one test.
	 *
	 * The dataProvider annotation tells PHPUnit which function it should use
	 * for the data to test.
	 *
	 *
	 * @param bool $expected_result
	 * @param string $new_email
	 * @param array|mixed $list_of_saved_emails
	 *
	 * @dataProvider data_is_new_and_valid_email
	 */
	function test_is_new_and_valid_email( $expected_result, $new_email, $list_of_saved_emails ) {
		$actual_result = \tenup\demo\is_new_and_valid_email( $new_email, $list_of_saved_emails );
		$this->assertSame( $expected_result, $actual_result );
	}

	/**
	 * Data provider.
	 *
	 * @return array {
	 *     @type array {
	 *         @type bool $expected_result
	 *         @type string $new_email
	 *         @type array $list_of_saved_emails
	 *     }
	 * }
	 */
	function data_is_new_and_valid_email() {
		return array(
			// Valid email address that doesn't exist.
			array(
				true,
				'new@email.com',
				array(
					'alternate@email.com',
					'alternate2@email.com',
				),
			),
			// Valid email that already exists.
			array(
				false,
				'new@email.com',
				array(
					'alternate@email.com',
					'alternate1@email.com',
					'new@email.com',
				),
			),
			// Invalid email.
			array(
				false,
				'not-an-email',
				array(),
			),
		);
	}
}