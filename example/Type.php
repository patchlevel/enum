<?php

declare(strict_types=1);

namespace Patchlevel\Enum\Example;

use Patchlevel\Enum\ExtendedEnum;

/**
 * @psalm-immutable
 * @method static self EXTERN()
 * @method static self INTERN()
 */
final class Type extends ExtendedEnum
{
    private const INTERN = 'intern';
    private const EXTERN = 'extern';
}

$test = Type::INTERN();
