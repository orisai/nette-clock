# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [Unreleased](https://github.com/orisai/nette-clock/compare/1.0.1...HEAD)

### Added

- symfony/clock compatibility - automatically configure `ClockInterface` service and set static `Clock`, if package is
  installed

### Changed

- Requires `orisai/clock:^1.2.0`

## [1.0.1](https://github.com/orisai/nette-clock/compare/1.0.0...1.0.1) - 2022-12-09

### Changed

- Composer
	- allows PHP 8.2
	- requires orisai/clock:^1.1.0

## [1.0.0](https://github.com/orisai/nette-clock/releases/tag/1.0.0) - 2022-08-19

### Added

- `ClockExtension`
	- registers `Clock` service
	- configures `now()` shortcut function
