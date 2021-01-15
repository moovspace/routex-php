<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

final class DataTest extends TestCase
{
    /**
	 * @depends testProducerFirst
     * @dataProvider additionProvider
     */
    public function testAdd(int $a, int $b, int $expected): void
    {
        $this->assertSame($expected, $a + $b);
    }

    public function additionProvider(): array
    {
        return [
            [0, 0, 0],
            [0, 1, 1],
            [1, 0, 1],
            [1, 1, 3]
        ];
	}

	public function additionProviderA(): array
    {
        return [
            'adding zeros'  => [0, 0, 0],
            'zero plus one' => [0, 1, 1],
            'one plus zero' => [1, 0, 1],
            'one plus one'  => [1, 1, 3]
        ];
	}

	public function testProducerFirst(): string
    {
        $this->assertTrue(true);

        return 'first';
	}

	public function testException(): void
    {
		$this->expectException(InvalidArgumentException::class);

		throw new Exception('Error...');
    }
}