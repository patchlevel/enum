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
 * @psalm-immutable
 */
abstract class Enum
{
    /**
     * @psalm-var array<T::*, T>
     * @var array<string, T>
     */
    private static array $values = [];

    /**
     * @psalm-var T::*
     * @var string
     */
    private string $value;

    /**
     * @psalm-pure
     * @psalm-param T::*
     *
     * @param string $value
     */
    final private function __construct(string $value)
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
     * @param static $enum
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
     * @psalm-param T::*
     * @param string $value
     *
     * @return static
     */
    public static function fromString(string $value): self
    {
        if (!self::$values) {
            self::init();
        }

        if (array_key_exists($value, self::$values) === false) {
            throw new EnumException(sprintf('invalid value [%s]', $value));
        }

        return self::$values[$value];
    }

    /**
     * @psalm-param T::*
     * @param string $value
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
     * @psalm-param T::*
     * @param string $value
     *
     * @return static
     */
    protected static function get(string $value): self
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
             * @psalm-var T::*
             * @var string $constantValue
             */
            $constantValue = $constantReflection->getValue();

            if (array_key_exists($constantValue, self::$values)) {
                throw new EnumException(sprintf('duplicated value [%s]', (string)$constantValue));
            }

            self::$values[$constantValue] = new static($constantValue);
        }
    }
}
