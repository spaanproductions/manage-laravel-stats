<?php

namespace Spaanproductions\ManageLaravelStats\Commands;

use Illuminate\Console\Command;

class ManageLaravelStatsCommand extends Command
{
    public $signature = 'manage-laravel-stats';

    public $description = 'My command';

    public function handle()
    {
        $this->comment('All done');
    }
}
