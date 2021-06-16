<?php

namespace Spaanproductions\ManageLaravelStats;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Spaanproductions\ManageLaravelStats\Commands\ManageLaravelStatsCommand;

class ManageLaravelStatsServiceProvider extends PackageServiceProvider
{
	public function configurePackage(Package $package): void
	{
		/*
		 * This class is a Package Service Provider
		 *
		 * More info: https://github.com/spatie/laravel-package-tools
		 */
		$package
			->name('manage-laravel-stats')
			->hasConfigFile('manage-stats')
			// ->hasViews()
			// ->hasMigration('create_manage-laravel-stats_table')
			->hasCommand(ManageLaravelStatsCommand::class);
	}
}
