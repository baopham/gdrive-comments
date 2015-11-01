<?php

namespace App\Providers;

use App\Mocks\MockedGoogleServiceDrive;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\ServiceProvider;

class GoogleClientServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
         $this->app->singleton(\Google_Client::class, function ($app) {
            $client = new \Google_Client();

            $client->setApplicationName('GDrive Comments');

            $client->setClientId(config('services.google.client_id'));

            $client->setClientSecret(config('services.google.client_secret'));

            $client->setAccessToken(Crypt::decrypt($app['auth']->user()->token));

            return $client;
        });

        $this->app->singleton(\Google_Service_Drive::class, function ($app) {
            if ($app->environment() === 'testing') {
                return new MockedGoogleServiceDrive();
            }

            $drive = new \Google_Service_Drive($app[\Google_Client::class]);

            return $drive;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
