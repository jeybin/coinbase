<?php

return [

    'COINBASE_API_KEY'     => env('COINBASE_API_KEY',null),
    'COINBASE_API_VERSION' => env('COINBASE_API_VERSION',null),
    'providers' => [
        // Other Service Providers
    
        Jeybin\Coinbase\Providers\CoinbaseServiceProvider::class,
    ],
];