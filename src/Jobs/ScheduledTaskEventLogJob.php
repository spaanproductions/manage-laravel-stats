<?php

namespace Spaanproductions\ManageLaravelStats\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Client\ConnectionException;

class ScheduledTaskEventLogJob implements ShouldQueue
{
	use Dispatchable;
	use InteractsWithQueue;
	use Queueable;
	use SerializesModels;

	public $payload;

	public function __construct(array $payload)
	{
		$this->payload = $payload;
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle()
	{
		if (is_null(config('manage-stats.token'))) {
			return;
		}

		if (empty(data_get($this->payload, 'task.command'))) {
			return;
		}

		try {
			Http::timeout(5)
				->retry(2, 10)
				->withHeaders([
					'Accept' => 'application/json',
					'x-api-token' => config('manage-stats.token'),
				])
				->post(config('manage-stats.base-url') . '/api/task-event', $this->payload);
		} catch (ConnectionException $exception) {
			// Do nothing.
		}
	}
}
