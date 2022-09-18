<?php

namespace Jeybin\Coinbase\Providers;

use Jeybin\Coinbase\CoinbaseClass;
use Illuminate\Support\ServiceProvider;
use Jeybin\Coinbase\Console\InstallCoinbasePackage;
use Jeybin\Coinbase\Controllers\CoinbaseChargesController;

class CoinbaseServiceProvider extends ServiceProvider
{

    public function register(){
        $this->mergeConfigFrom(__DIR__.'/../Config/config.php', 'coinbase');
    }
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(){

        if ($this->app->runningInConsole()) {

            /**
             * Adding tag to the publishing file
             */ 
            $this->publishes([
                __DIR__.'/../Config/config.php' =>   config_path('coinbase.php'),
              ], 'coinbase');

            $this->commands([
                InstallCoinbasePackage::class,
            ]);
        }


        $this->app->bind('coinbase', function($app) {
            return new CoinbaseChargesController();
        });

    }
}