<?php

declare(strict_types=1);

namespace Patchlevel\Enum\Tests;

use Patchlevel\Enum\Exception\BadMethodCall;
use Patchlevel\Enum\Tests\Enums\Type;
use PHPUnit\Framework\TestCase;

class ExtendedEnumTest extends TestCase
{
    public function testToStringCast(): void
    {
        $type = Type::intern();

        self::assertEquals('intern', (string)$type);
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

    public function testCreateSameInstanceFromMagic(): void
    {
        $a = Type::intern();
        $b = Type::intern();

        self::assertSame($a, $b);
    }

    public function testJsonSerializable(): void
    {
        $completed = Type::intern();

        $jsonEncoded = json_encode($completed, JSON_THROW_ON_ERROR);
        $jsonDecoded = json_decode($jsonEncoded, true, 512, JSON_THROW_ON_ERROR);

        self::assertSame($completed, Type::fromString($jsonDecoded));
    }
}
