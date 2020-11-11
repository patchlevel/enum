<?php

declare(strict_types=1);

namespace Patchlevel\Enum;

use ReflectionClass;
use function array_key_exists;
use function array_values;
use function count;
use function sprintf;

/**
 * @template T
 */
trait Enumerated
{
    /**
     * @var array<string, T>
     */
    private static array $values = [];

    /**
     * @var T::*
     */
    private string $value;

    /**
     * @param T::* $value
     */
    private function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * @return array<int, T>
     * @psalm-return list<T>
     */
    public static function values(): array
    {
        if (count(self::$values) === 0) {
            self::init();
        }

        return array_values(self::$values);
    }

    /**
     * @param T $enum
     *
     * @return bool
     */
    public function equals(self $enum): bool
    {
        return $this->value === $enum->value;
    }

    public function toString(): string
    {
        return $this->value;
    }

    /**
     * @param T::* $value
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
     * @param T::* $value
     */
    public static function isValid(string $value): bool
    {
        try {
            self::fromString($value);
        } catch (EnumException $exception) {
            return false;
        }

        return true;
    }

    /**
     * @param T::* $value
     *
     * @return T
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
            /** @var string $constantValue */
            $constantValue = $constantReflection->getValue();

            if (array_key_exists($constantValue, self::$values)) {
                throw new EnumException(sprintf('duplicated value "%s"', $constantValue));
            }

            self::$values[$constantValue] = new static($constantValue);
        }
    }
}
