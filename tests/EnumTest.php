<?php

declare(strict_types=1);

namespace Patchlevel\Enum\Tests;

use BadMethodCallException;
use Patchlevel\Enum\EnumException;
use Patchlevel\Enum\Tests\Enums\BrokenEnum;
use Patchlevel\Enum\Tests\Enums\Status;
use Patchlevel\Enum\Tests\Enums\Type;
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

    public function testCreateMagicStaticCall(): void
    {
        $type = Type::intern();

        self::assertInstanceOf(Type::class, $type);
        self::assertEquals('intern', $type->toString());
    }

    public function testCreateMagicStaticCallInvalid(): void
    {
        $this->expectException(BadMethodCallException::class);

        Type::foo();
    }

    public function testCreateFromStringInvalid(): void
    {
        $this->expectException(EnumException::class);

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

    public function testCreateSameInstanceFromMagic(): void
    {
        $a = Type::intern();
        $b = Type::intern();

        self::assertSame($a, $b);
    }

    public function testCreateNotSameInstance(): void
    {
        $a = Status::created();
        $b = Status::pending();

        self::assertNotSame($a, $b);
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

    public function testDuplicatedValue(): void
    {
        $this->expectException(EnumException::class);

        BrokenEnum::created();
    }
}
