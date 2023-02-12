<?php

declare(strict_types=1);

namespace Asddaniel\UniversalLaravel\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
// use NordCoders\LaravelServiceMaker\Contracts\CreateServiceContractFileActionContract;
// use NordCoders\LaravelServiceMaker\Contracts\CreateServiceFileActionContract;

final class LaravelUniversalMakerCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'make:universalmodel
    {name : The name of the model you want to create}
    ';

    /**
     * @var string
     */
    protected $description = 'Create a universal model ';

    /**
     * @var string
     */
    protected $type = 'Model';

    public function handle(): int {
        $this->call("make:universalmodelFile", [
            "name"=>$this->argument('name')
        ]);



        $this->comment('Universal model  created with success!');

        return self::SUCCESS;
    }
}
