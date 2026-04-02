<?php

namespace InEngine\Alert\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Application;
use InEngine\Alert\AlertServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

/**
 * TestCase
 * Orchestra Testbench base case: registers the Alert service provider and factory name guessing.
 */
class TestCase extends Orchestra
{
    /**
     * getEnvironmentSetUp
     * Uses the in-memory testing database connection for package tests.
     *
     * @param  Application  $app
     * @return void
     */
    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
         foreach (\Illuminate\Support\Facades\File::allFiles(__DIR__ . '/../database/migrations') as $migration) {
            (include $migration->getRealPath())->up();
         }
         */
    }

    /**
     * setUp
     * Registers factory resolution for models under the InEngine\Alert\Database\Factories namespace.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'InEngine\\Alert\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    /**
     * getPackageProviders
     * Service providers loaded for each test application container.
     *
     * @param  Application  $app
     * @return array<int, class-string>
     */
    protected function getPackageProviders($app)
    {
        return [
            AlertServiceProvider::class,
        ];
    }
}
