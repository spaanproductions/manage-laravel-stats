<?php

namespace Spaanproductions\ManageLaravelStats\ShareableMetrics\Metrics;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Spaanproductions\ManageLaravelStats\ShareableMetrics\Metric;
use Spaanproductions\ManageLaravelStats\ShareableMetrics\CollectableMetric;

class InstalledPackages extends Metric implements CollectableMetric
{
	public function name(): string
	{
		return 'packages';
	}

	public function value()
	{
		$composerJson = json_decode(File::get(base_path('composer.json')), true);

		$packages = Arr::get($composerJson, 'require', []);
		$devPackages = Arr::get($composerJson, 'require-dev', []);

		return [
			'require' => $packages,
			'require-dev' => $devPackages,
		];
	}
}
