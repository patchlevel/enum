<?php

declare(strict_types=1);

namespace Patchlevel\Enum;

use BadMethodCallException;
use function array_key_exists;

/**
 * @psalm-immutable
 */
trait MagicEnumerated
{
    use Enumerated;

    /**
     * @psalm-assert self::* $name
     * @param array<mixed> $arguments
     *
     * @throws BadMethodCallException
     */
    public static function __callStatic(string $name, array $arguments): self
    {
        self::init();

        if (array_key_exists($name, self::$values) === false) {
            throw new BadMethodCallException("No static method or enum constant '$name' in class " . static::class);
        }

        return self::$values[$name];
    }

    public function __toString(): string
    {
        return $this->toString();
    }
}
