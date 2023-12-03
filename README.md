<h1 align="center">
	<img src="https://github.com/orisai/.github/blob/main/images/repo_title.png?raw=true" alt="Orisai"/>
	<br/>
	Nette Clock
</h1>

<p align="center">
    <a href="https://github.com/orisai/clock">Orisai Clock</a> and <a href="https://github.com/symfony/clock">Symfony Clock</a> integration for <a href="https://nette.org">Nette</a>
</p>

<p align="center">
	<a href="https://www.php-fig.org/psr/psr-20/">PSR-20</a> compatible
</p>

<p align="center">
	📄 Check out our <a href="docs/README.md">documentation</a>.
</p>

<p align="center">
	💸 If you like Orisai, please <a href="https://orisai.dev/sponsor">make a donation</a>. Thank you!
</p>

<p align="center">
	<a href="https://github.com/orisai/nette-clock/actions?query=workflow%3ACI">
		<img src="https://github.com/orisai/nette-clock/workflows/CI/badge.svg">
	</a>
	<a href="https://coveralls.io/r/orisai/nette-clock">
		<img src="https://badgen.net/coveralls/c/github/orisai/nette-clock/v1.x?cache=300">
	</a>
	<a href="https://dashboard.stryker-mutator.io/reports/github.com/orisai/nette-clock/v1.x">
		<img src="https://badge.stryker-mutator.io/github.com/orisai/nette-clock/v1.x">
	</a>
	<a href="https://packagist.org/packages/orisai/nette-clock">
		<img src="https://badgen.net/packagist/dt/orisai/nette-clock?cache=3600">
	</a>
	<a href="https://packagist.org/packages/orisai/nette-clock">
		<img src="https://badgen.net/packagist/v/orisai/nette-clock?cache=3600">
	</a>
	<a href="https://choosealicense.com/licenses/mpl-2.0/">
		<img src="https://badgen.net/badge/license/MPL-2.0/blue?cache=3600">
	</a>
<p>

##

```php
use Orisai\Clock\Clock;
use function Orisai\Clock\now;

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
		// Or
		$currentTime = now();
	}

}
```
