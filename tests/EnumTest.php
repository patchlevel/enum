<?php

declare(strict_types=1);

namespace Patchlevel\Enum\Tests;

use Patchlevel\Enum\EnumException;
use Patchlevel\Enum\Tests\Enums\Status;
use PHPUnit\Framework\TestCase;

class EnumTest extends TestCase
{
    public function testCreateEnum()
    {
        $status = Status::created();

        self::assertInstanceOf(Status::class, $status);
        self::assertEquals('created', $status->toString());
    }

    public function testCreateFromString()
    {
        $status = Status::fromString('created');

        self::assertInstanceOf(Status::class, $status);
        self::assertEquals('created', $status->toString());
    }

    public function testCreateFromStringInvalid()
    {
        self::expectException(EnumException::class);

        Status::fromString('foo');
    }

    public function testCreateSameInstance()
    {
        $a = Status::created();
        $b = Status::created();

        self::assertSame($a, $b);
    }

    public function testCreateSameInstanceFromString()
    {
        $a = Status::created();
        $b = Status::fromString('created');

        self::assertSame($a, $b);
    }

    public function testValid()
    {
        self::assertTrue(Status::isValid('created'));
    }

    public function testNotValid()
    {
        self::assertFalse(Status::isValid('foo'));
    }

    public function testEquals()
    {
        $a = Status::created();
        $b = Status::created();

        self::assertTrue($a->equals($b));
    }

    public function testNotEquals()
    {
        $a = Status::created();
        $b = Status::completed();

        self::assertFalse($a->equals($b));
    }

    public function testValues()
    {
        $values = Status::values();

        self::assertEquals(
            [
                Status::created(),
                Status::pending(),
                Status::running(),
                Status::completed()
            ],
            $values
        );
    }
}
