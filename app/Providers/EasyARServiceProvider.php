<?php

namespace App\Providers;

use App\Api\EasyARClient;
use App\Api\EasyARClientSdkCRS;
use Illuminate\Support\ServiceProvider;

class EasyARServiceProvider extends ServiceProvider
{

    public function __construct($app)
    {
        parent::__construct($app);
    }


    public function register()
    {
        $this->app->singleton(EasyARClientSdkCRS::class,function($app){
            return new EasyARClientSdkCRS(
                env("EASYAR_API_KEY"),
                env("EASYAR_API_SECRET"),
                env("EASYAR_APP_ID"),
                env("EASYAR_CLOUD_URL")
            );
        });

        $this->app->alias(EasyARClientSdkCRS::class,"easyar");


        $this->app->singleton(EasyARClient::class);



    }

    public function provides()
    {

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
