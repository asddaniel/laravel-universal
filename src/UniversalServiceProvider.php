<?php
namespace Asddaniel\UniversalLaravel;


use Spatie\LaravelPackageTools\PackageServiceProvider;
use Spatie\LaravelPackageTools\Package;
use Asddaniel\UniversalLaravel\Commands\LaravelUniversalMakerCommand;
use Asddaniel\UniversalLaravel\Commands\Files\CreateUniversalModelFileCommand;

class UniversalServiceProvider extends PackageServiceProvider{

    public function configurePackage(Package $package): void
    {
        $package
        ->name('laravel-universal')
        ->hasConfigFile("universal-config")
        ->hasCommand(LaravelUniversalMakerCommand::class)
        ->hasCommand(CreateUniversalModelFileCommand::class)
        ->hasMigrations(["create_donnees_table",
        "create_relations_table",
        "create_colonnes_table",
        "create_enregistrements_table"])
        ->runsMigrations();

        ;
    }
}
