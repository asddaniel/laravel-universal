<?php

namespace Asddaniel\LaravelPackageSkeleton\Commands;

use Illuminate\Console\Command;

class LaravelPackageSkeletonCommand extends Command
{
    public $signature = 'laravel-package-skeleton';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
