<?php

namespace Spaanproductions\ManageLaravelStats\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ScheduledTaskEventLogJob implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
		Http::withHeaders([
			'Accept' => 'application/json',
			'x-api-token' => config('manage-stats.token'),
		])->post(config('manage-stats.base-url') . '/api/task-event', $this->payload);
	}
}
