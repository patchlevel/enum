<?php

declare(strict_types=1);

namespace Patchlevel\Enum\Tests\Enums;

use JsonSerializable;
use Patchlevel\Enum\ExtendedEnumerated;

/**
 * @psalm-immutable
 * @method static self extern()
 * @method static self intern()
 */
final class Type implements JsonSerializable
{
    use ExtendedEnumerated;

    private const INTERN = 'intern';
    private const EXTERN = 'extern';
}
