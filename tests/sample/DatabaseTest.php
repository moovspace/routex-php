<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

/**
 * @requires extension mysqli
 */
final class DatabaseTest extends TestCase
{
	protected function setUp(): void
    {
        if (!extension_loaded('mysqli')) {
            $this->markTestSkipped(
              'The MySQLi extension is not available.'
            );
        }
	}

	/**
     * @requires PHP >= 8.0
     */
    public function testConnection(): void
    {
		// Test requires the mysqli extension and PHP >= 8.0
    }

	public function testSomething(): void
    {
        // Optional: Test anything here, if you want.
        $this->assertTrue(true, 'This should already work.');

        // Stop here and mark this test as incomplete.
        // $this->markTestIncomplete(
        //   'This test has not been implemented yet.'
        // );
    }
}