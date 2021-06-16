<?php

namespace Spaanproductions\ManageLaravelStats\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Spaanproductions\ManageLaravelStats\ShareableMetrics\Metric;
use Spaanproductions\ManageLaravelStats\ShareableMetrics\Metrics\GitInfo;
use Spaanproductions\ManageLaravelStats\ShareableMetrics\Metrics\InstalledPackages;
use Spaanproductions\ManageLaravelStats\ShareableMetrics\Metrics\LaravelVersion;
use Spaanproductions\ManageLaravelStats\ShareableMetrics\Metrics\Name;
use Spaanproductions\ManageLaravelStats\ShareableMetrics\Metrics\PhpVersion;
use Spaanproductions\ManageLaravelStats\ShareableMetrics\Metrics\ServerInfo;
use Spaanproductions\ManageLaravelStats\ShareableMetrics\Metrics\Url;

class ManageLaravelStatsCommand extends Command
{
    public $signature = 'manage-laravel-stats';

    public $description = 'My command';

    public function handle()
    {
        $data = collect([
            Name::class,
            Url::class,
            GitInfo::class,
            InstalledPackages::class,
            PhpVersion::class,
            LaravelVersion::class,
            ServerInfo::class,
        ])->map(function (string $metricClass) {
            return new $metricClass();
        })->map(function (Metric $metric) {
            return $metric->toArray();
        })->mapWithKeys(function ($item) {
            return [
                key($item) => $item[key($item)],
            ];
        });

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . config('manage-stats.token'),
        ])->post('http://managelaravel.test/api/stats', $data->toArray());

        if (! $response->ok()) {
            $this->error('Something went wrong..');
            $this->error($response->json('message'));

            return 1;
        }

        $this->comment('All done');

        dd($response->json());

        return 0;
    }
}
