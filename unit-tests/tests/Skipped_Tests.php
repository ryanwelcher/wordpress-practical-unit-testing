<?php
/**
 * Class Skipped_Tests
 *
 *
 * @group skipped
 */
class Skipped_Tests extends PHPUnit_Framework_TestCase {

	/**
	 * Simple Test
	 */
	function test_this_is_true() {
		$this->assertTrue( true );
	}

	/**
	 * Very simple test to show some of the assertions
	 *
	 * @link {https://phpunit.de/manual/current/en/appendixes.assertions.html}
	 */
	function test_basic_assertions() {

		$this->assertFalse( false );

		$this->assertTrue( true );

		$this->assertEquals( 'thing', 'thing' );

		$this->assertSame( 'thing', 'thing' ); // Strict equality.

		$this->assertInstanceOf( 'WP_Error', new WP_Error() );

		$this->assertGreaterThan( 1, 100 );

		$this->assertLessThan( 100, 1 );
	}


	/**
	 * An example of how to mark a test as incomplete
	 */
	function test_this_one_isnt_ready() {

		$this->markTestIncomplete(
			'This test has not been implemented yet.'
		);
	}


	/**
	 * An example of how to skip a test
	 */
	function test_this_one_is_skipped() {

		$this->markTestSkipped(
			'Some examples below'
		);
	}
}