<?php declare(strict_types = 1);

namespace OriNette\Clock\DI;

use Nette\DI\CompilerExtension;
use Nette\DI\ContainerBuilder;
use Nette\DI\Definitions\ServiceDefinition;
use Nette\Schema\Expect;
use Nette\Schema\Schema;
use Orisai\Clock\Adapter\OrisaiToSymfonyClockAdapter;
use Orisai\Clock\Clock;
use Orisai\Clock\ClockHolder;
use Orisai\Clock\SystemClock;
use Orisai\Utils\Dependencies\Dependencies;
use stdClass;
use Symfony\Component\Clock\Clock as SymfonyClockHolder;
use Symfony\Component\Clock\ClockInterface as SymfonyClock;

/**
 * @property-read stdClass $config
 */
final class ClockExtension extends CompilerExtension
{

	public function getConfigSchema(): Schema
	{
		return Expect::structure([]);
	}

	public function loadConfiguration(): void
	{
		$builder = $this->getContainerBuilder();

		$clockDefinition = $this->registerClock($builder);
		$this->registerClockGetter($clockDefinition);

		if (Dependencies::isPackageLoaded('symfony/clock')) {
			$symfonyClockAdapterDefinition = $this->registerSymfonyClockAdapter($builder, $clockDefinition);
			$this->registerSymfonyClockGetter($symfonyClockAdapterDefinition);
		}
	}

	private function registerClock(ContainerBuilder $builder): ServiceDefinition
	{
		return $builder->addDefinition($this->prefix('clock'))
			->setFactory(SystemClock::class)
			->setType(Clock::class);
	}

	private function registerClockGetter(ServiceDefinition $clockDefinition): void
	{
		$init = $this->getInitialization();
		$init->addBody(ClockHolder::class . '::setClock($this->getService(?));', [
			$clockDefinition->getName(),
		]);
	}

	private function registerSymfonyClockAdapter(
		ContainerBuilder $builder,
		ServiceDefinition $clockDefinition
	): ServiceDefinition
	{
		return $builder->addDefinition($this->prefix('symfony.adapter'))
			->setFactory(OrisaiToSymfonyClockAdapter::class, [
				$clockDefinition,
			])
			->setType(SymfonyClock::class)
			->setAutowired([SymfonyClock::class]);
	}

	private function registerSymfonyClockGetter(ServiceDefinition $clockDefinition): void
	{
		$init = $this->getInitialization();
		$init->addBody(SymfonyClockHolder::class . '::set($this->getService(?));', [
			$clockDefinition->getName(),
		]);
	}

}
