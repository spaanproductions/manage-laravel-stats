<?php

namespace Spaanproductions\ManageLaravelStats\ShareableMetrics\Metrics;

use Spaanproductions\ManageLaravelStats\Helpers\SourceControl\GitInfoCollector;
use Spaanproductions\ManageLaravelStats\ShareableMetrics\CollectableMetric;
use Spaanproductions\ManageLaravelStats\ShareableMetrics\Metric;

class GitInfo extends Metric implements CollectableMetric
{
    public function name(): string
    {
        return 'git-info';
    }

    public function value()
    {
        return resolve(GitInfoCollector::class)->collect()->toArray();
    }
}
