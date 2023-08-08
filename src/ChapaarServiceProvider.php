<?php

namespace Aryala7\Chapaar;

use Illuminate\Support\Facades\Notification;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ChapaarServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {

        // $this->app->when(KavenegarChannel::class)
        //     ->needs(SmsIrConnector::class)
        //     ->give(function () {
        //         return new SmsIrConnector();
        //     });
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        Notification::extend('sms',function($app){
            return new SmsChannel();
        });
        $package
            ->name('chapaar')
            ->hasConfigFile();
    }
}
