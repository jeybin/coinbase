# Laravel wrapper for the Coinbase Commerce API

## Installation


You can install the package via composer:

```bash
  composer require jeybin/coinbase
```
    
The service provider will automatically register itself.

You must publish the config file with:

```bash
  php artisan coinbase:install
```

This is the contents of the config file that will be published at config/coinbase.php:

```bash
 return [
    'COINBASE_API_KEY'     => env('COINBASE_API_KEY',null),
    'COINBASE_API_VERSION' => env('COINBASE_API_VERSION',null),
    'providers' => [
        // Other Service Providers
    
        Jeybin\Coinbase\Providers\CoinbaseServiceProvider::class,
    ],
];
```



    
## Useful links

 - [Laravel](https://laravel.com/docs/9.x)
 - [Coinbase Docs](https://docs.cloud.coinbase.com/commerce/docs)
 - [Coinbase API References](https://docs.cloud.coinbase.com/commerce/reference/getcharges)

