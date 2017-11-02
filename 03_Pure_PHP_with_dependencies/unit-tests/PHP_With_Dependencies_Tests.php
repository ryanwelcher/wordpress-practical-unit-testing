<?php
/**
 * Class Simple_Tests
 *
 * Tests that just use PHPUnit
 */

class PHP_With_Dependencies_Tests extends \PHPUnit\Framework\TestCase {
	
	/**
	 * Simple unit test with hardcoded values
	 */
	function test_is_new_and_valid_email_once() {
		
		$email_manager = $this->createMock(EmailManager::class );
		$email_manager->expects( $this->exactly( 1) )
		              ->method( 'get_known_list' )
		              ->willReturn(
		              	array(
		              		'alternate@email.com',
			                'alternate2@email.com',
		                )
						);
		
		$expected_result = true;
		$actual_result   = is_new_and_valid_email( 'new@email.com', $email_manager );

		$this->assertSame( $expected_result, $actual_result );
	}

	/**
	 * Simple unit test with a dataprovider so we can run many assertions in one test.
	 *
	 * The dataProvider annotation tells PHPUnit which function it should use
	 * for the data to test.
	 *
	 *
	 * @param bool   $expected_result
	 * @param string $new_email
	 * @param array  $list_of_saved_emails
	 *
	 * @dataProvider data_is_new_and_valid_email
	 */
	function test_is_new_and_valid_email( $expected_result, $new_email, $list_of_saved_emails ) {
		$email_manager = $this->createMock(EmailManager::class );
		$email_manager->expects( $this->exactly( 1) )
		              ->method( 'get_known_list' )
		              ->willReturn( $list_of_saved_emails );
		
		$actual_result = is_new_and_valid_email( $new_email, $email_manager );
		
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
	
	/**
	 * Tests adding a new email to the manager class.
	 *
	 * @param $address
	 * @param $expected_result
	 *
	 * @dataProvider data_add_new_email_address
	 */
	function test_add_new_email_address( $address, $expected_result) {
		$email_manager = $this->createMock(EmailManager::class );
		$email_manager->expects( $this->atMost( 1 ) )
		              ->method( 'add_address' )
		              ->willReturn( $expected_result);
		
		$result = add_new_email_address( $address, $email_manager );
		$this->assertSame( $expected_result, $result );
	}
	
	/**
	 * Data provider.
	 *
	 * @return array {
	 *     @type array
	 *         @type string $new_email
	 *         @type bool   $expected_result
	 *     }
	 * }
	 */
	function data_add_new_email_address() {
		return array(
			array(
				'email@email.com',
				true,
			),
			array(
				'',
				false
			)
		);
	}
}