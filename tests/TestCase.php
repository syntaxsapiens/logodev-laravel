<?php

namespace Syntaxsapiens\LogoDev\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * Get package providers for Testbench.
     *
     * @param  \Illuminate\Foundation\Application  $app
     */
    protected function getPackageProviders($app): array
    {
        return [
            \Syntaxsapiens\LogoDev\LogoDevServiceProvider::class,
        ];
    }

    /**
     * Get package aliases for Testbench.
     *
     * @param  \Illuminate\Foundation\Application  $app
     */
    protected function getPackageAliases($app): array
    {
        return [
            'LogoDev' => \Syntaxsapiens\LogoDev\Facades\LogoDev::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     */
    protected function defineEnvironment($app): void
    {
        $app['config']->set('logodev.publishable_key', 'test-pub-key');
        $app['config']->set('logodev.secret_key', 'test-secret-key');
    }
}
