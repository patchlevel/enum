<?php

declare(strict_types=1);

namespace Patchlevel\Enum;

use JsonSerializable;
use Patchlevel\Enum\Exception\BadMethodCall;
use Patchlevel\Enum\Exception\InvalidValue;

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
        try {
            return static::fromString($name);
        } catch (InvalidValue $e) {
            throw new BadMethodCall(
                $name,
                static::keys()
            );
        }
    }

    public function __toString(): string
    {
        return $this->toString();
    }
}
