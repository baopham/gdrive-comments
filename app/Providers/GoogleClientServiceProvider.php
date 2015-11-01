<?php

namespace App\Providers;

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
            $client = new \Google_Client();

            $client->setApplicationName('GDrive Comments');

            $client->setClientId(config('services.google.client_id'));

            $client->setClientSecret(config('services.google.client_secret'));

            return $client;
        });
    }
}
