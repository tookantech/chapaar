<?php

namespace TookanTech\Chapaar;

use Illuminate\Support\Facades\Notification;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ChapaarServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        Notification::extend('sms', function ($app) {
            return new SmsChannel();
        });
        $package
            ->name('chapaar')
            ->hasConfigFile();
    }
}
