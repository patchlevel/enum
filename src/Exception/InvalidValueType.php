<?php

declare(strict_types=1);

namespace Patchlevel\Enum\Exception;

use function sprintf;

final class InvalidValueType extends EnumException
{
    public function __construct(string $constant)
    {
        parent::__construct(sprintf(
            'Invalid value in ::%s. value need to be a string.',
            $constant
        ));
    }
}
