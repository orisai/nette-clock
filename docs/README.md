# Nette Clock

[Orisai Clock](https://github.com/orisai/clock) integration for [Nette](https://nette.org)

## Content

- [Setup](#setup)
- [Current time](#current-time)
- [Tests](#tests)
- [Clocks](#clocks)

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

Request `Clock` interface and get current time from clock

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

Or get time via static function

```php
use function Orisai\Clock\now;

$currentTime = now(); // \DateTimeImmutable
```

## Tests

Configure clock to return exact time for testing

```neon
services:
	orisai.clock.clock:
        # Accepts epoch second (timestamp)
		factory: Orisai\Clock\FrozenClock(978307200)
		type: Orisai\Clock\FrozenClock
```

## Clocks

`Clock` implementations and their usage are described by [orisai/clock](https://github.com/orisai/clock) package.
