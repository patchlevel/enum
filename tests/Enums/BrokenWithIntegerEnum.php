<?php

declare(strict_types=1);

namespace Patchlevel\Enum\Tests\Enums;

use Patchlevel\Enum\Enum;

final class BrokenWithIntegerEnum extends Enum
{
    private const CREATED = 1;
    private const PENDING = 2;

    public static function created(): self
    {
        return self::get(self::CREATED);
    }

    public static function pending(): self
    {
        return self::get(self::PENDING);
    }
}
