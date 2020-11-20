<?php

declare(strict_types=1);

namespace Patchlevel\Enum;

use Patchlevel\Enum\Exception\DuplicateValue;
use Patchlevel\Enum\Exception\InvalidValue;
use ReflectionClass;
use function array_key_exists;
use function array_map;
use function array_values;
use function count;

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
     * @throws InvalidValue
     */
    public static function fromString(string $value): self
    {
        self::init();

        if (array_key_exists($value, self::$values) === false) {
            throw new InvalidValue($value, array_map(static fn (self $value) => $value->toString(), self::$values));
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
     * @psalm-return self::*
     */
    public function toString(): string
    {
        return $this->value;
    }

    /**
     * @psalm-param self::* $value
     */
    private static function get(string $value): self
    {
        self::init();

        return self::$values[$value];
    }

    /**
     * @throws DuplicateValue
     */
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
                throw new DuplicateValue($constantValue, static::class);
            }

            self::$values[$constantValue] = new static($constantValue);
        }
    }
}
