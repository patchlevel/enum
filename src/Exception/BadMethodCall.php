<?php

declare(strict_types=1);

namespace Patchlevel\Enum\Exception;

use function array_map;
use function implode;
use function sprintf;

final class BadMethodCall extends EnumException
{
    /**
     * @param array<string> $values
     */
    public function __construct(string $value, array $values)
    {
        parent::__construct(sprintf(
            'Invalid method [::%s()] called. Valid methods are: %s',
            $value,
            implode(
                ', ',
                array_map(
                    static fn (string $value) => sprintf('::%s()', $value),
                    $values
                )
            )
        ));
    }
}
