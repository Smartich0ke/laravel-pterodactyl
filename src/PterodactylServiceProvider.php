<?php

namespace Artichoke\Pterodactyl;

use Illuminate\Support\ServiceProvider;

class PterodactylServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/pterodactyl.php' => config_path('pterodactyl.php'),
        ], 'config');
        Pterodactyl::init();

    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/pterodactyl.php', 'pterodactyl'
        );
    }
}
