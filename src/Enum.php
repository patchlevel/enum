<?php

declare(strict_types=1);

namespace Patchlevel\Enum;

interface Enum
{
    /**
     * @return array<int, self>
     */
    public static function values(): array;

    public function equals(self $enum): bool;

    public function toString(): string;

    public static function fromString(string $value): self;

    public static function isValid(string $value): bool;
}
