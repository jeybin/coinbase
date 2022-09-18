<?php

namespace Jeybin\Coinbase\Providers;

use Illuminate\Support\ServiceProvider;
use Jeybin\Coinbase\Console\InstallCoinbasePackage;

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

    }
}