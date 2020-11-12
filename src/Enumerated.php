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
 * @psalm-method static self self::*()
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
        if (count(self::$values) === 0) {
            self::init();
        }

        return array_values(self::$values);
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
     * @throws EnumException
     */
    public static function fromString(string $value): self
    {
        if (!self::$values) {
            self::init();
        }

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
        if (!self::$values) {
            self::init();
        }

        return array_key_exists($value, self::$values);
    }

    /**
     * @psalm-param self::* $value
     */
    private static function get(string $value): self
    {
        if (!self::$values) {
            self::init();
        }

        return self::$values[$value];
    }

    private static function init(): void
    {
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

    /**
     * @psalm-assert self::* $name
     *
     * @return static
     * @throws BadMethodCallException
     */
    public static function __callStatic(string $name, array $arguments)
    {
        if (!self::$values) {
            self::init();
        }

        if (array_key_exists($name, self::$values) === false) {
            throw new BadMethodCallException("No static method or enum constant '$name' in class " . static::class);
        }

        return self::$values[$name];
    }
}
