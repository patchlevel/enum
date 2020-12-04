<?php

declare(strict_types=1);

use Patchlevel\Enum\Example\Direction;
use Patchlevel\Enum\Example\Status;
use Patchlevel\Enum\Example\Type;

$created = Status::created();
$intern = Type::INTERN();
$directionUp = Direction::UP();

// this will result int the string "up"
$encodedDirectionUp = json_encode($directionUp, JSON_THROW_ON_ERROR);
