<?php

declare(strict_types=1);

namespace Patchlevel\Enum;

use function sprintf;

final class DuplicateValue extends EnumException
{
    public function __construct(string $value, string $enum)
    {
        parent::__construct(sprintf('Duplicated value [%s] for enum [%s] found', $value, $enum));
    }
}
