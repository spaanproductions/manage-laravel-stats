<?php

namespace Spaanproductions\ManageLaravelStats\ShareableMetrics\Metrics;

use Illuminate\Console\Application;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Console\Scheduling\Schedule;
use Spaanproductions\ManageLaravelStats\ShareableMetrics\Metric;
use Spaanproductions\ManageLaravelStats\ShareableMetrics\CollectableMetric;

class ScheduledTasks extends Metric implements CollectableMetric
{
	public function name(): string
	{
		return 'scheduled-tasks';
	}

	public function value()
	{
		return collect(app(Schedule::class)->events())
			->filter(function (Event $event) {
				return app()->environment($event->environments) || empty($event->environments);
			})
			->map(function (Event $event) {
				return [
					'expression' => $event->expression,
					'command' => $this->getCommand($event),
					'description' => $event->description,
					'timezone' => $event->timezone,
				];
			})->toArray();
	}

	protected function getCommand(Event $event)
	{
		return collect(explode(' ', $event->command))
			->skipUntil(function ($item) {
				return \Str::contains($item, Application::artisanBinary());
			})->skip(1)->implode(' ');
	}
}
