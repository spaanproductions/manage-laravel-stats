<?php

namespace Spaanproductions\ManageLaravelStats\ShareableMetrics\Metrics;

use Spaanproductions\ManageLaravelStats\ShareableMetrics\CollectableMetric;
use Spaanproductions\ManageLaravelStats\ShareableMetrics\Metric;

class PhpVersion extends Metric implements CollectableMetric
{
    public function name(): string
    {
        return 'php-version';
    }

    public function value()
    {
        return phpversion();
    }
}
