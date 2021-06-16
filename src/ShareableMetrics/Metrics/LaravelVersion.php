<?php

namespace Spaanproductions\ManageLaravelStats\ShareableMetrics\Metrics;

use Spaanproductions\ManageLaravelStats\ShareableMetrics\CollectableMetric;
use Spaanproductions\ManageLaravelStats\ShareableMetrics\Metric;

class LaravelVersion extends Metric implements CollectableMetric
{
    public function name(): string
    {
        return 'laravel-version';
    }

    public function value()
    {
        return app()->version();
    }
}
