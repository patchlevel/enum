<?php

declare(strict_types=1);

namespace Patchlevel\Enum\Example;

use const JSON_THROW_ON_ERROR;
use Patchlevel\Enum\ExtendedEnum;
use function json_encode;

/**
 * @psalm-immutable
 * @method static self UP()
 * @method static self DOWN()
 * @method static self LEFT()
 * @method static self RIGHT()
 */
final class Direction extends ExtendedEnum
{
    private const UP = 'up';
    private const DOWN = 'down';
    private const LEFT = 'left';
    private const RIGHT = 'right';
}
