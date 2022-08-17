<?php declare(strict_types = 1);

namespace OriNette\Clock\DI;

use Nette\DI\CompilerExtension;
use Nette\DI\ContainerBuilder;
use Nette\DI\Definitions\ServiceDefinition;
use Nette\Schema\Expect;
use Nette\Schema\Schema;
use Orisai\Clock\Clock;
use Orisai\Clock\ClockHolder;
use Orisai\Clock\SystemClock;
use stdClass;

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

}
