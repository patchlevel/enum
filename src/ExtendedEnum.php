<?php

declare(strict_types=1);

namespace Patchlevel\Enum;

use JsonSerializable;
use Patchlevel\Enum\Exception\BadMethodCall;

use function array_key_exists;
use function array_keys;

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
     *
     * @return static
     *
     * @throws BadMethodCall
     */
    public static function __callStatic(string $name, array $arguments): self
    {
        $constantMap = self::constantMap();

        if (!array_key_exists($name, $constantMap)) {
            throw new BadMethodCall(
                $name,
                array_keys($constantMap)
            );
        }

        return $constantMap[$name];
    }

    public function __toString(): string
    {
        return $this->toString();
    }
}
