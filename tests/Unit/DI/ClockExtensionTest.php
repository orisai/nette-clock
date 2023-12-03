<?php declare(strict_types = 1);

namespace Tests\OriNette\Clock\Unit\DI;

use OriNette\DI\Boot\ManualConfigurator;
use Orisai\Clock\Adapter\OrisaiToSymfonyClockAdapter;
use Orisai\Clock\Clock;
use Orisai\Clock\ClockHolder;
use Orisai\Clock\FrozenClock;
use Orisai\Clock\SystemClock;
use Orisai\Utils\Dependencies\DependenciesTester;
use PHPUnit\Framework\TestCase;
use Psr\Clock\ClockInterface;
use Symfony\Component\Clock\Clock as SymfonyClockHolder;
use Symfony\Component\Clock\ClockInterface as SymfonyClock;
use function dirname;
use function interface_exists;
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
		self::assertSame($clock, $container->getByType(ClockInterface::class));
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
		self::assertSame($clock, $container->getByType(ClockInterface::class));
		self::assertSame($clock, $container->getByType(Clock::class));
		self::assertSame($clock, $container->getByType(FrozenClock::class));
	}

	public function testSymfonyIntegration(): void
	{
		// Workaround for minimal PHP version - Symfony requires PHP 8.1, we only 7.4
		if (!interface_exists(SymfonyClock::class)) {
			self::markTestSkipped('symfony/clock is not installed.');
		}

		$configurator = new ManualConfigurator($this->rootDir);
		$configurator->setForceReloadContainer();
		$configurator->addConfig(__DIR__ . '/config.neon');

		$container = $configurator->createContainer();

		$clock = $container->getByType(SymfonyClock::class);
		self::assertInstanceOf(OrisaiToSymfonyClockAdapter::class, $clock);

		self::assertSame($clock, SymfonyClockHolder::get());
	}

	/**
	 * @runInSeparateProcess
	 */
	public function testSymfonyIntegrationNotLoaded(): void
	{
		DependenciesTester::addIgnoredPackages(['symfony/clock']);

		$configurator = new ManualConfigurator($this->rootDir);
		$configurator->setForceReloadContainer();
		$configurator->addConfig(__DIR__ . '/config.neon');
		$configurator->addStaticParameters(['__unique' => __METHOD__]);

		$container = $configurator->createContainer();

		$clock = $container->getByType(SymfonyClock::class, false);
		self::assertNull($clock);
	}

}
