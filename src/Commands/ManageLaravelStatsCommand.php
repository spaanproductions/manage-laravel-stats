<?php

namespace Spaanproductions\ManageLaravelStats\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Spaanproductions\ManageLaravelStats\ShareableMetrics\Metric;
use Spaanproductions\ManageLaravelStats\ShareableMetrics\Metrics\Url;
use Spaanproductions\ManageLaravelStats\ShareableMetrics\Metrics\Name;
use Spaanproductions\ManageLaravelStats\ShareableMetrics\Metrics\GitInfo;
use Spaanproductions\ManageLaravelStats\ShareableMetrics\Metrics\PhpVersion;
use Spaanproductions\ManageLaravelStats\ShareableMetrics\Metrics\ServerInfo;
use Spaanproductions\ManageLaravelStats\ShareableMetrics\Metrics\LaravelVersion;
use Spaanproductions\ManageLaravelStats\ShareableMetrics\Metrics\ScheduledTasks;
use Spaanproductions\ManageLaravelStats\ShareableMetrics\Metrics\InstalledPackages;
use Spaanproductions\ManageLaravelStats\ShareableMetrics\Metrics\ManageLaravelTeam;

class ManageLaravelStatsCommand extends Command
{
	public $signature = 'manage-laravel-stats {--dry-run}';

	public $description = 'My command';

	public function handle()
	{
		$data = collect([
			ManageLaravelTeam::class,
			Name::class,
			Url::class,
			GitInfo::class,
			InstalledPackages::class,
			PhpVersion::class,
			LaravelVersion::class,
			ServerInfo::class,
			ScheduledTasks::class,
		])->map(function (string $metricClass) {
			return new $metricClass();
		})->map(function (Metric $metric) {
			return $metric->toArray();
		})->mapWithKeys(function ($item) {
			return [
				key($item) => $item[key($item)],
			];
		});

		if ($this->option('dry-run')) {
			dump($data->toArray());

			return 0;
		}

		$url = app()->isLocal()
			? 'http://managelaravel.test/api/stats'
			: 'https://manage-laravel.spaan.dev/api/stats';

		$response = Http::withHeaders([
			'Accept' => 'application/json',
			'Authorization' => 'Bearer ' . config('manage-stats.token'),
		])->post($url, $data->toArray());

		dump($response->body());

		if ( ! $response->ok()) {
			$this->error('Something went wrong..');
			$this->error($response->json('message'));

			return 1;
		}


		$this->comment('All done');

		$this->info(sprintf('The current state is "%s", latest Laravel version is %s', $response->json('status'), $response->json('desired_laravel_version')));

		return 0;
	}
}
