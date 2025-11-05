<?php

namespace GetDbInfo\Providers;

use Illuminate\Support\ServiceProvider;
use src\Commands\GetDbCommand;

class GetDbProvider extends ServiceProvider
{

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



    public function register()
    {
        $this->app->singleton(GetDbCommand::class);
    }
}
