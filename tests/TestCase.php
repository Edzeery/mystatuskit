<?php

namespace Edzeery\MyStatusKit\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use Edzeery\MyStatusKit\StatusKitServiceProvider;

abstract class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            StatusKitServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('status-kit-theme.default_framework', 'bootstrap');
    }
}
