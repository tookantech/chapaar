<?php

namespace TookanTech\Chapaar\Tests;

use TookanTech\Chapaar\ChapaarServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'TookanTech\\Chapaar\\Tests\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            ChapaarServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');
        //

        $migration = include __DIR__.'/Database/Migrations/2023_01_20_104330096199_create_users_table.php';
        $migration->up();

    }
}
