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
            \ConorSmith\Music\Persistence\AlbumDbRepository::class
        );

        $this->app->bind(
            \ConorSmith\Music\Model\ArtistRepository::class,
            \ConorSmith\Music\Persistence\AlbumDbRepository::class
        );

        $this->app->bind(
            \ConorSmith\Music\Model\DiscographyRepository::class,
            \ConorSmith\Music\Persistence\AlbumDbRepository::class
        );
    }
}
