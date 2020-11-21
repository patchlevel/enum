<?php

declare(strict_types=1);

namespace Patchlevel\Enum\Example;

use Patchlevel\Enum\ExtendedEnumerated;

/**
 * @psalm-immutable
 * @method static self extern()
 * @method static self intern()
 */
final class Type
{
    use ExtendedEnumerated;

    private const INTERN = 'intern';
    private const EXTERN = 'extern';
}

$test = Type::intern();
