<?php

declare(strict_types=1);

namespace Patchlevel\Enum\Tests;

use Patchlevel\Enum\Exception\DuplicateValue;
use Patchlevel\Enum\Exception\InvalidValue;
use Patchlevel\Enum\Exception\InvalidValueType;
use Patchlevel\Enum\Tests\Enums\BrokenEnum;
use Patchlevel\Enum\Tests\Enums\BrokenWithIntegerEnum;
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
        $this->expectException(InvalidValue::class);
        $this->expectExceptionMessage('Invalid value [foo] found. Valid values are: created, pending, running, completed');

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
                Status::completed(),
            ],
            $values
        );
    }

    public function testKeys(): void
    {
        $values = Status::keys();

        self::assertEquals(
            [
                'created',
                'pending',
                'running',
                'completed',
            ],
            $values
        );
    }

    public function testDuplicatedValue(): void
    {
        $this->expectException(DuplicateValue::class);
        $this->expectExceptionMessage('Duplicated value [created] for enum [Patchlevel\Enum\Tests\Enums\BrokenEnum] found');

        BrokenEnum::created();
    }

    public function testInvalidType(): void
    {
        $this->expectException(InvalidValueType::class);
        $this->expectExceptionMessage('Invalid value in Patchlevel\Enum\Tests\Enums\BrokenWithIntegerEnum::CREATED. value need to be a string.');

        BrokenWithIntegerEnum::isValid('foo');
    }

    public function testSerializable(): void
    {
        $completed = Status::completed();
        $unserialized = unserialize(serialize($completed));

        self::assertEquals($completed, $unserialized);
        self::assertNotSame($completed, $unserialized);
    }
}
