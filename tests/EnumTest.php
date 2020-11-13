<?php

declare(strict_types=1);

namespace Patchlevel\Enum\Tests;

use Patchlevel\Enum\EnumException;
use Patchlevel\Enum\Tests\Enums\Status;
use PHPUnit\Framework\TestCase;

class EnumTest extends TestCase
{
    public function testCreateEnum(): void
    {
        $status = Status::created();

        self::assertInstanceOf(Status::class, $status);
        self::assertEquals('created', $status->toString());
    }

    public function testCreateFromString(): void
    {
        $status = Status::fromString('created');

        self::assertInstanceOf(Status::class, $status);
        self::assertEquals('created', $status->toString());
    }

    public function testCreateFromStringInvalid(): void
    {
        self::expectException(EnumException::class);

        Status::fromString('foo');
    }

    public function testCreateSameInstance(): void
    {
        $a = Status::created();
        $b = Status::created();

        self::assertSame($a, $b);
    }

    public function testCreateSameInstanceFromString(): void
    {
        $a = Status::created();
        $b = Status::fromString('created');

        self::assertSame($a, $b);
    }

    public function testValid(): void
    {
        self::assertTrue(Status::isValid('created'));
    }

    public function testNotValid(): void
    {
        self::assertFalse(Status::isValid('foo'));
    }

    public function testEquals(): void
    {
        $a = Status::created();
        $b = Status::created();

        self::assertTrue($a->equals($b));
    }

    public function testNotEquals(): void
    {
        $a = Status::created();
        $b = Status::completed();

        self::assertFalse($a->equals($b));
    }

    public function testValues(): void
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
