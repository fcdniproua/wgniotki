<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use zcrmsdk\crm\setup\restclient\ZCRMRestClient;
use zcrmsdk\oauth\ZohoOAuth;

class ZohoServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('zoho', function ($app) {
            $configuration = [
                'client_id' => config('zoho.client_id'),
                'client_secret' => config('zoho.client_secret'),
                'redirect_uri' => config('zoho.redirect_uri'),
                'current_user_email' => config('zoho.current_user_email'),
                'api_domain' => config('zoho.api_domain'),
                'access_type' => config('zoho.access_type'),
                'token_persistence_path' => config('zoho.token_persistence_path'),
            ];

            ZCRMRestClient::initialize($configuration);

            return ZCRMRestClient::getInstance();
        });
    }

    public function boot()
    {
        if (!file_exists(config('zoho.token_persistence_path'))) {
            mkdir(config('zoho.token_persistence_path'), 0755, true);
        }
    }
}