<?php

namespace Aryala7\Chapaar;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Aryala7\Chapaar\Commands\ChapaarCommand;

class ChapaarServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('chapaar')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_chapaar_table')
            ->hasCommand(ChapaarCommand::class);
    }
}
