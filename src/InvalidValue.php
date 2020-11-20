<?php

declare(strict_types=1);

namespace Patchlevel\Enum;

use function implode;
use function sprintf;

final class InvalidValue extends EnumException
{
    /**
     * @param array<string> $values
     */
    public function __construct(string $value, array $values)
    {
        parent::__construct(sprintf(
            'Invalid value [%s] found. Valid values are: %s',
            $value,
            implode(', ', $values)
        ));
    }
}
