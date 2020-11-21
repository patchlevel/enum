<?php

declare(strict_types=1);

namespace Patchlevel\Enum\Tests\Enums;

use Patchlevel\Enum\Enum;

final class BrokenEnum extends Enum
{
    private const CREATED = 'created';
    private const PENDING = 'created';

    public static function created(): self
    {
        return self::get(self::CREATED);
    }

    public static function pending(): self
    {
        return self::get(self::PENDING);
    }
}
