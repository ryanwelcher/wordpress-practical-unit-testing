<?php
/**
 * Class Skipped_Tests
 *
 *
 * @group dont-run
 */
class Skipped_Tests extends PHPUnit_Framework_TestCase {

	/**
	 * Very simple test to show some of the assertions
	 *
	 * @link {https://phpunit.de/manual/current/en/appendixes.assertions.html}
	 */
	function test_basic_assertions() {

		// if ( $thing1 == $thing2 )
		$this->assertEquals( $thing1, $thing2 );

		// if ( $thing1 === $thing2 )
		$this->assertSame( $thing1, $thing2 );

		$this->assertFalse( $thing_that_is_false ); //this is the first failure - why not the others above?
		$this->assertTrue( $thing_that_is_true );

		$this->assertInstanceOf( 'WP_Post', $post );

		// 100 is greater than 1
		$this->assertGreaterThan( 100, 1 );
		// 1 is less that 100
		$this->assertLessThan( 1, 100 );
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


	/**
	 * Simple Test
	 */
	function test_this_is_true() {
		$this->assertTrue( true );
	}
}