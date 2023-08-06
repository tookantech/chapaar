<?php

namespace Aryala7\Chapaar;

use Aryala7\Chapaar\Commands\ChapaarCommand;
use Aryala7\Chapaar\Drivers\Kavenegar\KavenegarChannel;
use Aryala7\Chapaar\Drivers\Kavenegar\KavenegarConnector;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ChapaarServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {

        $this->app->when(KavenegarChannel::class)
            ->needs(KavenegarConnector::class)
            ->give(function () {
                return new KavenegarConnector();
            });
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('chapaar')
            ->hasConfigFile();
    }
}
