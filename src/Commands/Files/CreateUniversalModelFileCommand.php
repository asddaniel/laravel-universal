<?php

declare(strict_types=1);

namespace Asddaniel\UniversalLaravel\Commands\Files;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

final class CreateUniversalModelFileCommand extends GeneratorCommand
{
    /**
     * @var string
     */
    protected $name = 'make:universalmodelFile {name}';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Model';

    /**
     * @return string
     */
    protected function getStub(): string
    {
        return __DIR__.'/../../../stubs/model.stub';
    }

    /**
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        $modelName = str(
            string: $this->argument('name')
        )
            ->ucfirst();

        return "{$rootNamespace}\\UniversalModels";
    }

    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     *
     * @throws FileNotFoundException
     */
    protected function buildClass($name): string
    {
        $modelName = "{$name}";

        $stub = $this->files->get($this->getStub());

        return $this->replaceNamespace($stub, $modelName)
                    ->replaceClass($stub, $name);
    }

    /**
     * Replace the class name for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return string
     */
    protected function replaceClass($stub, $name): string
    {
        $modelName = "{$name}";
        $class = str_replace($this->getNamespace($modelName).'\\', '', $modelName);
        // $contractName = str_replace($this->getNamespace($modelName).'\\', '', $name).'Contract';
        // $contractNamespace = $this->rootNamespace()."Services\\Contracts\\{$contractName}";

        $replace = [
            '{{ class }}' => $class,
            '{{class}}' => $class,
            // '{{ contract }}' => $contractName,
            // '{{contract}}' => $contractName,
            // '{{ contractNamespace }}' => $contractNamespace,
            // '{{contractNamespace}}' => $contractNamespace,
        ];

        return str_replace(array_keys($replace), array_values($replace), $stub);
    }

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name): string
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        return $this->laravel['path'].'/'.str_replace('\\', '/', $name.'').'.php';
    }
}
