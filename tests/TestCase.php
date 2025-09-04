<?php

namespace Companue\Contacts\Tests;

use Companue\Contacts\Facades\Contacts;
use Companue\Contacts\Providers\PackageServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getEnvironmentSetup($app)
    {
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connection.testing', [
            'driver' => 'sqlite',
            'database' => ':memory:'
        ]);
    }

    protected function getPackageProviders($app)
    {
        return [
            PackageServiceProvider::class
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Contacts' => Contacts::class
        ];
    }
}
