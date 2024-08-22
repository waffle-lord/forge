<?php

namespace App\Console\Commands;

use App\Jobs\ResolveDependenciesJob;
use App\Jobs\ResolveSptVersionsJob;
use Illuminate\Console\Command;

class ResolveVersionsCommand extends Command
{
    protected $signature = 'app:resolve-versions';

    protected $description = 'Resolve SPT and dependency versions for all mods.';

    public function handle(): void
    {
        ResolveSptVersionsJob::dispatch()->onQueue('long');
        ResolveDependenciesJob::dispatch()->onQueue('long');

        $this->info('The import job has been added to the queue.');
    }
}
