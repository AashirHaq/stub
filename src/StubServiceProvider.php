<?php

namespace Aashirhaq\Stub;

use Illuminate\Support\ServiceProvider;
use Aashirhaq\Stub\Console\Commands\GenerateSkeleton;

class StubServiceProvider extends ServiceProvider
{
    /**
     * Register any stub services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any stub services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                GenerateSkeleton::class,
            ]);
        }
    }
}
