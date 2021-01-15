<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

class SomeClass
{
    public function doSomething()
    {
		// Do something.
    }
}

final class StubTest extends TestCase
{
    public function testStub(): void
    {
        // Create a stub for the SomeClass class.
        $stub = $this->createStub(SomeClass::class);

        // Configure the stub.
        $stub->method('doSomething')
             ->willReturn('foo');

        // Calling $stub->doSomething() will now return
        // 'foo'.
        $this->assertSame('foo', $stub->doSomething());
	}

	public function testReturnSelf(): void
    {
        // Create a stub for the SomeClass class.
        $stub = $this->createStub(SomeClass::class);

        // Configure the stub.
        $stub->method('doSomething')
             ->will($this->returnSelf());

        // $stub->doSomething() returns $stub
        $this->assertSame($stub, $stub->doSomething());
	}

	public function testReturnArgumentStub(): void
    {
        // Create a stub for the SomeClass class.
        $stub = $this->createStub(SomeClass::class);

        // Configure the stub.
        $stub->method('doSomething')
             ->will($this->returnArgument(0));

        // $stub->doSomething('foo') returns 'foo'
        $this->assertSame('foo', $stub->doSomething('foo'));

        // $stub->doSomething('bar') returns 'bar'
        $this->assertSame('bar', $stub->doSomething('bar'));
	}

	public function testStub1(): void
    {
        // Create a stub for the SomeClass class.
        $stub = $this->getMockBuilder(SomeClass::class)
                     ->disableOriginalConstructor()
                     ->disableOriginalClone()
                     ->disableArgumentCloning()
                     ->disallowMockingUnknownTypes()
                     ->getMock();

        // Configure the stub.
        $stub->method('doSomething')
             ->willReturn('foo');

        // Calling $stub->doSomething() will now return
        // 'foo'.
        $this->assertSame('foo', $stub->doSomething());
    }
}

// https://github.com/sebastianbergmann/money/blob/master/tests/MoneyTest.php
// https://phpunit.readthedocs.io/en/9.5/test-doubles.html