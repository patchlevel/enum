<?php

declare(strict_types=1);

namespace Patchlevel\Enum\Example;

use Patchlevel\Enum\Enum;
use Patchlevel\Enum\Enumerated;

/**
 * @psalm-immutable
 */
final class Status implements Enum
{
    use Enumerated;

    private const CREATED = 'created';
    private const PENDING = 'pending';
    private const RUNNING = 'running';
    private const COMPLETED = 'completed';

    public static function created(): self
    {
        return self::get(self::CREATED);
    }

    public static function pending(): self
    {
        return self::get(self::PENDING);
    }

    public static function running(): self
    {
        return self::get(self::RUNNING);
    }

    public static function completed(): self
    {
        return self::get(self::COMPLETED);
    }
}

$test = Status::created();
