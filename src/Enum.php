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
     * @psalm-var array<class-string, array<string, static>>
     */
    private static array $valueMap = [];

    /**
     * @psalm-var array<class-string, array<string, static>>
     */
    private static array $constantMap = [];

    private string $value;

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

        return array_values(self::$valueMap[static::class]);
    }

    /**
     * @return array<int, string>
     */
    public static function keys(): array
    {
        self::init();

        return array_keys(self::$valueMap[static::class]);
    }

    /**
     * @throws InvalidValue
     * @return static
     */
    public static function fromString(string $value): self
    {
        self::init();

        if (array_key_exists($value, self::$valueMap[static::class]) === false) {
            throw new InvalidValue(
                $value,
                array_keys(self::$valueMap[static::class])
            );
        }

        return self::$valueMap[static::class][$value];
    }

    public static function isValid(string $value): bool
    {
        self::init();

        return array_key_exists($value, self::$valueMap[static::class]);
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

        return self::$valueMap[static::class][$value];
    }

    /**
     * @internal
     * @return array<string, static>
     */
    protected static function constantMap(): array
    {
        self::init();

        return self::$constantMap[static::class];
    }

    /**
     * @throws DuplicateValue
     */
    private static function init(): void
    {
        if (array_key_exists(static::class, self::$valueMap)) {
            return;
        }

        self::$valueMap[static::class] = [];

        $constantMap = (new ReflectionClass(static::class))->getReflectionConstants();

        foreach ($constantMap as $constantReflection) {
            $constantValue = $constantReflection->getValue();

            if (!is_string($constantValue)) {
                throw new InvalidValueType(static::class, $constantReflection->getName());
            }

            if (array_key_exists($constantValue, self::$valueMap[static::class])) {
                throw new DuplicateValue($constantValue, static::class);
            }

            $enum = new static($constantValue);

            self::$valueMap[static::class][$constantValue] = $enum;
            self::$constantMap[static::class][$constantReflection->getName()] = $enum;
        }
    }
}
