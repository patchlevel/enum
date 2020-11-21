<?php

declare(strict_types=1);

namespace Patchlevel\Enum\Tests\Enums;

use Patchlevel\Enum\ExtendedEnum;

/**
 * @psalm-immutable
 * @method static self extern()
 * @method static self intern()
 */
final class Type extends ExtendedEnum
{
    private const INTERN = 'intern';
    private const EXTERN = 'extern';
}
