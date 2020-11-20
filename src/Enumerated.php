<?php

declare(strict_types=1);

namespace Patchlevel\Enum;

use BadMethodCallException;
use ReflectionClass;
use function array_key_exists;
use function array_values;
use function count;
use function sprintf;

/**
 * @psalm-immutable
 */
trait Enumerated
{
    /**
     * @psalm-var array<string, self>
     */
    private static array $values = [];

    /**
     * @psalm-var self::*
     */
    private string $value;

    /**
     * @psalm-param self::* $value
     */
    final private function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * @return array<int, self>
     */
    public static function values(): array
    {
        self::init();

        return array_values(self::$values);
    }

    /**
     * @throws EnumException
     */
    public static function fromString(string $value): self
    {
        self::init();

        if (array_key_exists($value, self::$values) === false) {
            throw new EnumException(sprintf('invalid value "%s"', $value));
        }

        return self::$values[$value];
    }

    /**
     * @psalm-assert-if-true self::* $value
     */
    public static function isValid(string $value): bool
    {
        self::init();

        return array_key_exists($value, self::$values);
    }

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

    public function equals(self $enum): bool
    {
        return $this === $enum;
    }

    /**
     * @psalm-return self::*
     */
    public function toString(): string
    {
        return $this->value;
    }

    /**
     * @psalm-return self::*
     */
    public function jsonSerialize(): string
    {
        return $this->toString();
    }

    /**
     * @psalm-param self::* $value
     */
    private static function get(string $value): self
    {
        self::init();

        return self::$values[$value];
    }

    private static function init(): void
    {
        if (count(self::$values) > 0) {
            return;
        }

        $constants = (new ReflectionClass(static::class))->getReflectionConstants();

        foreach ($constants as $constantReflection) {
            /**
             * @var string $constantValue
             * @psalm-var self::*
             */
            $constantValue = $constantReflection->getValue();

            if (array_key_exists($constantValue, self::$values)) {
                throw new EnumException(sprintf('duplicated value "%s"', $constantValue));
            }

            self::$values[$constantValue] = new static($constantValue);
        }
    }
}
