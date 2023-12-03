# Nette Clock

[Orisai Clock](https://github.com/orisai/clock) and [Symfony Clock](https://github.com/symfony/clock) integration
for [Nette](https://nette.org)

[PSR-20](https://www.php-fig.org/psr/psr-20/) compatible

## Content

- [Setup](#setup)
- [Current time](#current-time)
- [Sleep](#sleep)
- [Shortcut function](#shortcut-function)
- [Tests](#tests)
- [Clocks](#clocks)
- [Compatibility](#compatibility)

## Setup

Install with [Composer](https://getcomposer.org)

```sh
composer require orisai/nette-clock
```

Register DI extension

```neon
extensions:
    orisai.clock: OriNette\Clock\DI\ClockExtension
```

## Current time

Request `Clock` interface and get current time from clock (or `Psr\Clock\ClockInterface` for `psr/clock` compatibility)

```php
use Orisai\Clock\Clock;

class ExampleService
{

	private Clock $clock;

	public function __construct(Clock $clock)
	{
		$this->clock = $clock;
	}

	public function doSomething(): void
	{
		$currentTime = $this->clock->now();
	}

}
```

## Sleep

To prevent waiting periods in tests, replace calls to `sleep()` and `usleep()` functions with `Clock->sleep()` method.

```php
$clock->sleep(
	1, // Seconds
	2, // Milliseconds
	3, // Microseconds
);
```

Or with named arguments, just:

```php
$clock->sleep(microseconds: 10);
```

## Shortcut function

Get current time statically

```php
use function Orisai\Clock\now;

$currentTime = now(); // \DateTimeImmutable
```

It is also possible to access clock statically

```php
use Orisai\Clock\ClockHolder;

$clock = ClockHolder::getClock();
```

## Tests

Configure clock to return exact time for testing

```neon
services:
	# Set timestamp
	orisai.clock.clock: Orisai\Clock\FrozenClock(978307200)
	# Or a date time instance
	orisai.clock.clock: Orisai\Clock\FrozenClock(\DateTimeImmutable('now'))
```

## Clocks

`Clock` implementations and their usage are described by [orisai/clock](https://github.com/orisai/clock) package.

## Compatibility

In case `symfony/clock` is installed, the extension automatically:

- registers adapter which makes `Symfony\Component\Clock\ClockInterface` available via DIC
- sets clock to static class `Symfony\Component\Clock\Clock` during DIC startup.
