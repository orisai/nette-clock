<?php declare(strict_types = 1);

namespace Tests\OriNette\Clock\Unit\DI;

use OriNette\DI\Boot\ManualConfigurator;
use Orisai\Clock\Clock;
use Orisai\Clock\ClockHolder;
use Orisai\Clock\FrozenClock;
use Orisai\Clock\SystemClock;
use PHPUnit\Framework\TestCase;
use function dirname;
use function mkdir;
use const PHP_VERSION_ID;

final class ClockExtensionTest extends TestCase
{

	private string $rootDir;

	protected function setUp(): void
	{
		parent::setUp();

		$this->rootDir = dirname(__DIR__, 3);
		if (PHP_VERSION_ID < 8_01_00) {
			@mkdir("$this->rootDir/var/build");
		}
	}

	public function testBasic(): void
	{
		$configurator = new ManualConfigurator($this->rootDir);
		$configurator->setForceReloadContainer();
		$configurator->addConfig(__DIR__ . '/config.neon');

		$container = $configurator->createContainer();

		$clock = $container->getService('orisai.clock.clock');
		self::assertInstanceOf(SystemClock::class, $clock);
		self::assertSame($clock, $container->getByType(Clock::class));
		self::assertSame($clock, ClockHolder::getClock());
	}

	public function testFrozenClock(): void
	{
		$configurator = new ManualConfigurator($this->rootDir);
		$configurator->setForceReloadContainer();
		$configurator->addConfig(__DIR__ . '/config.frozen.neon');

		$container = $configurator->createContainer();

		$clock = $container->getService('orisai.clock.clock');
		self::assertInstanceOf(FrozenClock::class, $clock);
		self::assertSame($clock, $container->getByType(Clock::class));
		self::assertSame($clock, $container->getByType(FrozenClock::class));
	}

}
