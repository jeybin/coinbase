<?php

namespace Jeybin\Coinbase\Console;

use Illuminate\Console\Command;

class InstallCoinbasePackage extends Command {

    protected $signature = 'coinbase:install';

    protected $description = 'Install the coinbase helper package from jeybin';

    public function handle() {
        $this->info('Installing Coinbase helper...');

        $this->info('Publishing configuration...');

        $this->call('vendor:publish', [
            '--provider' => "Jeybin\Coinbase\Providers\CoinbaseServiceProvider",
            '--tag' => "coinbase"
        ]);

        $this->info('Installed Coinbase');
    }
}