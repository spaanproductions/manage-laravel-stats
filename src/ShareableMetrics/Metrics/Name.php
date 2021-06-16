<?php

namespace Spaanproductions\ManageLaravelStats\ShareableMetrics\Metrics;

use Spaanproductions\ManageLaravelStats\ShareableMetrics\CollectableMetric;
use Spaanproductions\ManageLaravelStats\ShareableMetrics\Metric;

class Name extends Metric implements CollectableMetric
{
    public function name(): string
    {
        return 'name';
    }

    public function value()
    {
        return config('app.name');
    }
}
