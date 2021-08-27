<?php

namespace Spaanproductions\ManageLaravelStats\Helpers\Tasks;

use Illuminate\Support\Str;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Console\Scheduling\CallbackEvent;
use Spaanproductions\ManageLaravelStats\Facades\ManageLaravel;

class TaskIdentifier
{
    public const TYPE_CLOSURE = 'closure';
    public const TYPE_COMMAND = 'command';
    public const TYPE_JOB = 'job';
    public const TYPE_SHELL = 'shell';

    public function __invoke(Event $task)
    {
        if ($task instanceof CallbackEvent) {
            if (Str::of($task->command)->isEmpty() && $task->description && class_exists($task->description)) {
                return static::TYPE_JOB;
            }

            if (Str::of($task->command)->isEmpty() && Str::is($task->description, $task->getSummaryForDisplay())) {
                return static::TYPE_CLOSURE;
            }

            if (Str::of($task->getSummaryForDisplay())->is(['Closure', 'Callback'])) {
                return static::TYPE_CLOSURE;
            }
        }

        if (Str::contains(ManageLaravel::sanitisedCommand($task->command), 'artisan')) {
            return static::TYPE_COMMAND;
        }

        return static::TYPE_SHELL;
    }
}
