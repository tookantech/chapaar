<?php

namespace TookanTech\Chapaar;

use Illuminate\Support\Facades\Notification;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ChapaarServiceProvider extends PackageServiceProvider
{
    public function packageBooted()
    {
        Notification::extend('sms', function ($app) {
            return new SmsChannel();
        });
    }
    public function packageRegistered()
    {
        parent::packageRegistered();

        $this->app->register(EventServiceProvider::class);
    }

    public function configurePackage(Package $package): void
    {
        $package
            ->name('chapaar')
            ->hasTranslations()
            ->hasMigration('create_sms_messages_table')
            ->hasConfigFile();
    }
}
