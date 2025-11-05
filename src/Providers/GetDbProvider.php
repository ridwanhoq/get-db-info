<?php

namespace GetDbInfo\Providers;

use GetDbInfo\Commands\GetDbCommand;
use Illuminate\Support\ServiceProvider;

class GetDbProvider extends ServiceProvider
{


    public function register()
    {
        $this->app->singleton(GetDbCommand::class);
    }

    public function boot()
    {
        $this->app->booting(function ($app) {
            if ($app->runningInConsole()) {
                $this->commands([
                    GetDbCommand::class,
                ]);
            }
        });
    }
}
