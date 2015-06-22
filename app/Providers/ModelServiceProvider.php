<?php

namespace ConorSmith\Music\Providers;

use Illuminate\Support\ServiceProvider;

class ModelServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \ConorSmith\Music\Model\AlbumRepository::class,
            \ConorSmith\Music\Persistence\AlbumCacheRepository::class
        );
    }
}
