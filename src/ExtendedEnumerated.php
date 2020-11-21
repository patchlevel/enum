<?php

declare(strict_types=1);

namespace Patchlevel\Enum;

use Patchlevel\Enum\Exception\BadMethodCall;
use function array_key_exists;

/**
 * @psalm-immutable
 */
trait ExtendedEnumerated
{
    use Enumerated;

    /**
     * @psalm-assert self::* $name
     * @param array<mixed> $arguments
     *
     * @throws BadMethodCall
     */
    public static function __callStatic(string $name, array $arguments): self
    {
        self::init();

        if (array_key_exists($name, self::$values) === false) {
            throw new BadMethodCall($name, array_map(static fn (self $value) => $value->toString(), self::$values));
        }

        return self::$values[$name];
    }

    public function __toString(): string
    {
        return $this->toString();
    }
}
