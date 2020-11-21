<?php

declare(strict_types=1);

namespace Patchlevel\Enum;

use JsonSerializable;
use Patchlevel\Enum\Exception\BadMethodCall;
use function array_key_exists;

/**
 * @psalm-immutable
 */
abstract class ExtendedEnum extends Enum implements JsonSerializable
{
    public function jsonSerialize(): string
    {
        return $this->toString();
    }

    /**
     * @param array<mixed> $arguments
     * @return static
     *
     * @throws BadMethodCall
     */
    public static function __callStatic(string $name, array $arguments): self
    {
        self::init();

        if (array_key_exists($name, self::$values[static::class]) === false) {
            throw new BadMethodCall(
                $name,
                array_map(
                    static fn (self $value) => $value->toString(),
                    self::$values[static::class]
                )
            );
        }

        return self::$values[static::class][$name];
    }

    public function __toString(): string
    {
        return $this->toString();
    }
}
