<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use App\Core\Mail\Email;

final class EmailTest extends TestCase
{
    public function testCanBeCreatedFromValidEmailAddress(): void
    {
        $this->assertInstanceOf(
            Email::class,
            Email::FromString('user@example.com')
		);
    }

    public function testCannotBeCreatedFromInvalidEmailAddress(): void
    {
		$this->expectException(Exception::class);

		Email::FromString('invalid');
    }

    public function testCanBeUsedAsString(): void
    {
        $this->assertEquals(
            'user@example.com',
            Email::FromString('user@example.com')
        );
    }
}

/*
$this->fail();
$this->assertTrue(TRUE);
*/