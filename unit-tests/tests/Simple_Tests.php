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
	 * Very simple test to show some of the assertions
	 *
	 * @link {https://phpunit.de/manual/current/en/appendixes.assertions.html}
	 */
	function test_basic_assertions() {

		// Tests can be skipped when running the suite.
		$this->markTestSkipped(
			'Some examples below'
		);


		// if ( $thing1 == $thing2 )
		$this->assertEquals( $thing1, $thing2 );

		// if ( $thing1 === $thing2 )
		$this->assertSame( $thing1, $thing2 );

		$this->assertFalse( $thing_that_is_false );
		$this->assertTrue( $thing_that_is_true );

		$this->assertInstanceOf( 'WP_Post', $post );

		// 100 is greater than 1
		$this->assertGreaterThan( 100, 1 );
		// 1 is less that 100
		$this->assertLessThan( 1, 100 );
	}

	/**
	 * Marking a test as incomplete
	 */
	function test_this_one_isnt_ready() {
		$this->markTestIncomplete(
			'This test has not been implemented yet.'
		);
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
			// Invalid email that already exists.
			array(
				false,
				'not-an-email',
				array(),
			),
		);
	}
}