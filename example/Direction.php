<?php

declare(strict_types=1);

namespace Patchlevel\Enum\Example;

use Patchlevel\Enum\ExtendedEnum;

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
