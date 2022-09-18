<?php

namespace Jeybin\Coinbase\Facades;

use Illuminate\Support\Facades\Facade;

class CoinbaseFacades extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'coinbase';
    }
}
