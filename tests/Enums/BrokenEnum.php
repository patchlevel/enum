<?php

declare(strict_types=1);

namespace Patchlevel\Enum\Tests\Enums;

use Patchlevel\Enum\Enumerated;

final class BrokenEnum
{
    use Enumerated;

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
