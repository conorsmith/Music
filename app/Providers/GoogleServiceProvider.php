<?php

namespace ConorSmith\Music\Providers;

use Illuminate\Support\ServiceProvider;
use Google_Client;
use Google_Service_Drive;

class GoogleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(\Google_Client::class, function ($app) {
            $client = new Google_Client;

            $uriRoot = env(
                'GOOGLE_CALLBACK_EXPECTED_ROOT',
                $app[\Illuminate\Http\Request::class]->root()
            );

            $client->setAuthConfigFile(env('GOOGLE_API_SECRETS'));
            $client->addScope(Google_Service_Drive::DRIVE_READONLY);
            $client->setRedirectUri($uriRoot . "/auth/callback");

            $cache = $app['Illuminate\Contracts\Cache\Repository'];

            if ($cache->has('google.access_token')) {
                $client->setAccessToken($cache->get('google.access_token'));
            }

            return $client;
        });

        $this->app->singleton(\Google_Service_Drive::class, function ($app) {
            return new Google_Service_Drive($app[\Google_Client::class]);
        });
    }
}
