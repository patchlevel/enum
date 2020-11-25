<?php

declare(strict_types=1);

namespace Patchlevel\Enum;

use JsonSerializable;
use Patchlevel\Enum\Exception\BadMethodCall;

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
        $constants = self::constants();

        if (!array_key_exists($name, $constants)) {
            throw new BadMethodCall(
                $name,
                array_keys($constants)
            );
        }

        return $constants[$name];
    }

    public function __toString(): string
    {
        return $this->toString();
    }
}
