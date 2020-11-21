<?php

declare(strict_types=1);

namespace Patchlevel\Enum\Tests;

use Patchlevel\Enum\Exception\BadMethodCall;
use Patchlevel\Enum\Exception\DuplicateValue;
use Patchlevel\Enum\Exception\InvalidValue;
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
        $this->expectException(BadMethodCall::class);
        $this->expectExceptionMessage('Invalid method [::foo()] called. Valid methods are: ::intern(), ::extern()');

        Type::foo();
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
                Status::completed(),
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

    public function testSerializeAble(): void
    {
        $completed = Status::completed();
        $unserialized = unserialize(serialize($completed));

        self::assertEquals($completed, $unserialized);
        self::assertNotSame($completed, $unserialized);
    }

    public function testJsonSerializeAble(): void
    {
        $completed = Status::completed();

        $jsonEncoded = json_encode($completed, JSON_THROW_ON_ERROR);
        $jsonDecoded = json_decode($jsonEncoded, true, 512, JSON_THROW_ON_ERROR);

        self::assertSame($completed, Status::fromString($jsonDecoded));
    }
}
