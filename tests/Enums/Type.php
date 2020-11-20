<?php

declare(strict_types=1);

namespace Patchlevel\Enum\Tests\Enums;

use Patchlevel\Enum\MagicEnumerated;

/**
 * @psalm-immutable
 * @method static self extern()
 * @method static self intern()
 */
final class Type
{
    use MagicEnumerated;

    private const INTERN = 'intern';
    private const EXTERN = 'extern';
}
