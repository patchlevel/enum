<?php

declare(strict_types=1);

namespace Patchlevel\Enum\Example;

use const JSON_THROW_ON_ERROR;
use Patchlevel\Enum\ExtendedEnum;
use function json_encode;

/**
 * @psalm-immutable
 * @method static self up()
 * @method static self down()
 * @method static self left()
 * @method static self right()
 */
final class Direction extends ExtendedEnum
{
    private const UP = 'up';
    private const DOWN = 'down';
    private const LEFT = 'left';
    private const RIGHT = 'right';
}

$directionUp = Direction::up();

// this will result int the string "up"
$encodedDirectionUp = json_encode($directionUp, JSON_THROW_ON_ERROR);
