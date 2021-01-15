<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

final class ErrorTest extends TestCase
{
    public function testDeprecationCanBeExpected(): void
    {
        $this->expectDeprecation();

        // Optionally test that the message is equal to a string
        $this->expectDeprecationMessage('foo');

        // Or optionally test that the message matches a regular expression
        $this->expectDeprecationMessageMatches('/foo/');

        \trigger_error('foo', \E_USER_DEPRECATED);
    }

    public function testNoticeCanBeExpected(): void
    {
        $this->expectNotice();

        // Optionally test that the message is equal to a string
        $this->expectNoticeMessage('foo');

        // Or optionally test that the message matches a regular expression
        $this->expectNoticeMessageMatches('/foo/');

        \trigger_error('foo', \E_USER_NOTICE);
    }

    public function testWarningCanBeExpected(): void
    {
        $this->expectWarning();

        // Optionally test that the message is equal to a string
        $this->expectWarningMessage('foo');

        // Or optionally test that the message matches a regular expression
        $this->expectWarningMessageMatches('/foo/');

        \trigger_error('foo', \E_USER_WARNING);
    }

    public function testErrorCanBeExpected(): void
    {
        $this->expectError();

        // Optionally test that the message is equal to a string
        $this->expectErrorMessage('foo');

        // Or optionally test that the message matches a regular expression
        $this->expectErrorMessageMatches('/foo/');

        \trigger_error('foo', \E_USER_ERROR);
    }
}