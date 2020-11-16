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

or with static magic call method

```php
<?php

declare(strict_types=1);

namespace Patchlevel\Enum\Example;

use Patchlevel\Enum\Enumerated;

/**
 * @psalm-immutable
 * @method static self created()
 * @method static self pending()
 * @method static self running()
 * @method static self completed()
 */
final class Status
{
    use Enumerated;

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
