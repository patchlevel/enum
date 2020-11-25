<?php

declare(strict_types=1);

namespace Patchlevel\Enum;

use Patchlevel\Enum\Exception\DuplicateValue;
use Patchlevel\Enum\Exception\InvalidValue;
use Patchlevel\Enum\Exception\InvalidValueType;
use ReflectionClass;
use function array_key_exists;
use function array_values;

/**
 * @psalm-immutable
 */
abstract class Enum
{
    /**
     * @psalm-var array<string, array<string, static>>
     */
    private static array $values = [];

    protected string $value;

    final private function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * @return array<int, static>
     */
    public static function values(): array
    {
        self::init();

        return array_values(self::$values[static::class]);
    }

    /**
     * @return array<int, string>
     */
    public static function keys(): array
    {
        self::init();

        return array_keys(self::$values[static::class]);
    }

    /**
     * @throws InvalidValue
     * @return static
     */
    public static function fromString(string $value): self
    {
        self::init();

        if (array_key_exists($value, self::$values[static::class]) === false) {
            throw new InvalidValue(
                $value,
                array_keys(self::$values[static::class])
            );
        }

        return self::$values[static::class][$value];
    }

    public static function isValid(string $value): bool
    {
        self::init();

        return array_key_exists($value, self::$values[static::class]);
    }

    public function equals(self $enum): bool
    {
        return $this === $enum;
    }

    public function toString(): string
    {
        return $this->value;
    }

    /**
     * @return static
     */
    protected static function get(string $value): self
    {
        self::init();

        return self::$values[static::class][$value];
    }

    /**
     * @throws DuplicateValue
     */
    private static function init(): void
    {
        if (array_key_exists(static::class, self::$values)) {
            return;
        }

        self::$values[static::class] = [];

        $constants = (new ReflectionClass(static::class))->getReflectionConstants();

        foreach ($constants as $constantReflection) {
            $constantValue = $constantReflection->getValue();

            if (!is_string($constantValue)) {
                throw new InvalidValueType(static::class, $constantReflection->getName());
            }

            if (array_key_exists($constantValue, self::$values[static::class])) {
                throw new DuplicateValue($constantValue, static::class);
            }

            self::$values[static::class][$constantValue] = new static($constantValue);
        }
    }
}
