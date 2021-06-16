<?php

namespace Spaanproductions\ManageLaravelStats\ShareableMetrics\Metrics;

use Spaanproductions\ManageLaravelStats\ShareableMetrics\CollectableMetric;
use Spaanproductions\ManageLaravelStats\ShareableMetrics\Metric;

class Url extends Metric implements CollectableMetric
{
    public function name(): string
    {
        return 'url';
    }

    public function value()
    {
        return url('/');
    }
}
