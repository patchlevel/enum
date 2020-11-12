<?php

declare(strict_types=1);

namespace Patchlevel\Enum\Example;

use Patchlevel\Enum\Enumerated;

/**
 * @psalm-immutable
 */
final class Type
{
    use Enumerated;

    private const INTERN = 'intern';
    private const EXTERN = 'extern';
}


$type = Type::extern();
$type = Type::foo();

