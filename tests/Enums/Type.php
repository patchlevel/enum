<?php

declare(strict_types=1);

namespace Patchlevel\Enum\Tests\Enums;

use Patchlevel\Enum\Enumerated;

/**
 * @psalm-immutable
 * @method static self extern()
 * @method static self intern()
 */
final class Type
{
    use Enumerated;

    private const INTERN = 'intern';
    private const EXTERN = 'extern';
}
