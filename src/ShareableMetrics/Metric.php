<?php

namespace Spaanproductions\ManageLaravelStats\ShareableMetrics;

abstract class Metric
{
	public function toArray()
	{
		return [
			$this->name() => $this->value(),
		];
	}
}
