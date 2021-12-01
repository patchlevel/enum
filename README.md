[![Mutation testing badge](https://img.shields.io/endpoint?style=flat&url=https%3A%2F%2Fbadge-api.stryker-mutator.io%2Fgithub.com%2Fpatchlevel%2Fenum%2Fmaster)](https://dashboard.stryker-mutator.io/reports/github.com/patchlevel/enum/master)
[![Type Coverage](https://shepherd.dev/github/patchlevel/enum/coverage.svg)](https://shepherd.dev/github/patchlevel/enum)
[![Latest Stable Version](https://poser.pugx.org/patchlevel/enum/v)](//packagist.org/packages/patchlevel/enum)
[![License](https://poser.pugx.org/patchlevel/enum/license)](//packagist.org/packages/patchlevel/enum)

# enum


Small lightweight library to create enum in PHP without SPLEnum and strict comparisons allowed.

## dislcaimer

For project that are build on PHP >=8.1 please use the language build in Enums described in this rfc: https://wiki.php.net/rfc/enumerations
This library should not be needed anymore and will not support PHP >8.1.

## installation

```
composer require patchlevel/enum
```

## declaration

First of all you have to define your enum. 
To do this, you have to inherit from the `Enum` class, create a few constants (the value must be unique and a string) 
and define methods that return an enum representation. 
Here is an example:

```php
<?php

declare(strict_types=1);

namespace Patchlevel\Enum\Example;

use Patchlevel\Enum\Enum;

/**
 * @psalm-immutable
 */
final class Status extends Enum
{
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

`self::get()` ensures that exactly one instance of a representation really exists 
so that strict comparisons can be used without problems.

Alternatively, you can inherit the `ExtendedEnum`, which comes with a few conveniences, 
more about this under [ExtendedEnum](#extended-enum).

## api

### work with enum

```php
<?php 

declare(strict_types=1);

namespace Patchlevel\Enum\Example;

$status = Status::completed();

if ($status === Status::completed()) {
    echo "That's working";
}

// or use as typehint

function isFinished(Status $status): bool {
    return $status === Status::completed();
}

echo isFinished($status) ? 'yes' : 'no'; 

// or with the new php8.0 match feature:

$message = match ($status) {
    Status::created() => 'Process created',
    Status::pending() => 'Process pending',
    Status::running() => 'Process running',
    Status::completed() => 'Process completed',
    default => 'unknown status',
};

echo $message; // Process completed
```

Strict comparisons are not a problem as it ensures that there is only one instance of a certain value.

### fromString

You can create an enum from a string. It is checked internally whether the value is valid, 
otherwise an `InvalidValue` exception is thrown.

```php
$status = Status::fromString('pending');

if ($status === Status::pending()) {
    echo 'it works';
}
```

### toString

The other way around, an enum can also be converted back into a string.

```php
$status::completed();
echo $status->toString(); // completed
```

### equals

The Equals method is just a wrapper for `$a === $b`.

```php
$status = Status::completed();
$status->equals(Status::pending()); // false
```

### isValid

isValid can be used to check whether the transferred value is valid. The return value is a boolean.

```php
Status::isValid('foo'); // false
Status::isValid('completed'); // true
```

### values

You can also get all Enum instances.

```php
$instances = Status::values();

foreach ($instances as $instance) {
    echo $instance->toString(); // completed, pending, ...
}
```

### keys

Or all keys.

```php
$keys = Status::keys();

foreach ($keys as $key) {
    echo $key; // completed, pending, ...
}
```

## extended enum

Alternatively, it can also extend from `ExtendedEnum`. 
This implementation also provides other features mostly magic methods:
`__toString`, `__callStatic` and implementing `\JsonSerializable`.

```php
<?php

declare(strict_types=1);

namespace Patchlevel\Enum\Example;

use Patchlevel\Enum\ExtendedEnum;

/**
 * @psalm-immutable
 * @method static self CREATED()
 * @method static self PENDING()
 * @method static self RUNNING()
 * @method static self COMPLETED()
 */
final class Status extends ExtendedEnum
{
    private const CREATED = 'created';
    private const PENDING = 'pending';
    private const RUNNING = 'running';
    private const COMPLETED = 'completed';
}
```

### __callStatic

With the magic method `__callStatic` it is possible to create an Enum instance based only on the constant names. 
So no extra method is needed to be defined. If the constant name doesn't exist in the enum a `BadMethodCall` exception is thrown.

```php
$status = Status::CREATED();
```

### __toString

Just the magic method implementation of `toString`.

```php
$status = Status::CREATED();
echo (string)$status; // created
```

### JsonSerializable

The ExtendedEnum already implements the method `jsonSerialize` from the interface `\JsonSerializable`. 
This means that `\json_encode` will automatically serialize the value in the right manner. 
Beware that `\json_decode` won't automatically decode it back into the enum. This job must be tackled
manually. See this example:

```php
$status = Status::CREATED();
echo json_encode($status, JSON_THROW_ON_ERROR); // "created"
```
