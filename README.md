[![Mutation testing badge](https://img.shields.io/endpoint?style=flat&url=https%3A%2F%2Fbadge-api.stryker-mutator.io%2Fgithub.com%2Fpatchlevel%2Fenum%2Fmaster)](https://dashboard.stryker-mutator.io/reports/github.com/patchlevel/enum/master)

# enum

Small lightweight library to create enum in PHP without SPLEnum.

## installation

```
composer require patchlevel/enum
```

## declaration

First of all you have to define your enum.

```php
<?php

declare(strict_types=1);

namespace Patchlevel\Enum\Example;

use Patchlevel\Enum\Enumerated;

/**
 * @psalm-immutable
 */
final class Status
{
    use Enumerated;

    private const CREATED = 'created';
    private const PENDING = 'pending';
    private const RUNNING = 'running';
    private const COMPLETED = 'completed';

    public static function created(): self
    {
        return self::get(self::CREATED);
    }

    public static function pending(): self
    {
        return self::get(self::PENDING);
    }

    public static function running(): self
    {
        return self::get(self::RUNNING);
    }

    public static function completed(): self
    {
        return self::get(self::COMPLETED);
    }
}
```

or with static magic call methods, you need to use `ExtendedEnumerated`

```php
<?php

declare(strict_types=1);

namespace Patchlevel\Enum\Example;

use Patchlevel\Enum\ExtendedEnumerated;

/**
 * @psalm-immutable
 * @method static self created()
 * @method static self pending()
 * @method static self running()
 * @method static self completed()
 */
final class Status
{
    use ExtendedEnumerated;

    private const CREATED = 'created';
    private const PENDING = 'pending';
    private const RUNNING = 'running';
    private const COMPLETED = 'completed';
}
````

## usage

You can now use your enum.

```php
<?php 

declare(strict_types=1);

namespace Patchlevel\Enum\Example;

$status = Status::completed();

if ($status === Status::completed()) {
    echo "That's working";
}
```

the new "match" syntax, which is added with php 8, also works without problems.

```php
<?php 

declare(strict_types=1);

namespace Patchlevel\Enum\Example;

$status = Status::completed();

$message = match ($status) {
    Status::created() => 'Process created',
    Status::pending() => 'Process pending',
    Status::running() => 'Process running',
    Status::completed() => 'Process completed',
    default => 'unknown status',
};

echo $message; // Process completed
```

each value only exists once, which is why the strict comparison also works.

## features

### json serializeable

The trait already implements the method `jsonSerialize` from the interface `\JsonSerializable`. This means that you can
add the `\JsonSerializable` to your own enum and with this `\json_encode` will automatically serialize the value in the
right manner. Beware that `\json_decode` won't automatically decode it back into the enum. This job must be tackled
manually. See this example:

```php
<?php

declare(strict_types=1);

namespace Patchlevel\Enum\Example;

use JsonSerializable;
use Patchlevel\Enum\ExtendedEnumerated;
use function json_encode;
use const JSON_THROW_ON_ERROR;

/**
 * @psalm-immutable
 * @method static self up()
 * @method static self down()
 * @method static self left()
 * @method static self right()
 */
final class Direction implements JsonSerializable
{
    use ExtendedEnumerated;

    private const UP = 'up';
    private const DOWN = 'down';
    private const LEFT = 'left';
    private const RIGHT = 'right';
}

$directionUp = Direction::up();

// this will result int the string "up"
$encodedDirectionUp = json_encode($directionUp, JSON_THROW_ON_ERROR);
```
