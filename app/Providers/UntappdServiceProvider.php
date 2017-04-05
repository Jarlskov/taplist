<?php

namespace App\Providers;

use App\Services\UntappdService;
use Illuminate\Support\ServiceProvider;
use Pintlabs_Service_Untappd as Untappd;

class UntappdServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(UntappdService::class, function($app) {
            $config = array(
                'clientId' => env('UNTAPPD_CLIENTID', ''),
                'clientSecret' => env('UNTAPPD_CLIENTSECRET', ''),
                'accessToken' => env('UNTAPPD_ACCESSTOKEN', ''),
                'redirectUri' => env('UNTAPPD_REDIRECTURI', ''),
            );

            return new UntappdService($config);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [UntappdService::class];
    }
}
