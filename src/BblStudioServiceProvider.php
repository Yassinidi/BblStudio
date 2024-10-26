<?php

namespace BblStudio\BblStudio;

use Illuminate\Support\ServiceProvider;

class BblStudioServiceProvider extends ServiceProvider
{

        public function boot()
        {
            // Load routes
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

            // Publish assets
            $this->publishes([
                __DIR__.'/../public' => public_path('vendor'),
            ], 'laravel-assets');

            // Publish views
            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/bblstudio'),
            ], 'laravel-views');

            // Publish config
            $this->publishes([
                __DIR__.'/../config/bblstudio.php' => config_path('bblstudio.php'),
            ], 'config');

            // Merge the config file so that package defaults are available
            $this->mergeConfigFrom(
                __DIR__.'/../config/bblstudio.php', 'bblstudio'
            );
        }

        public function register()
        {
            // Register package services
        }


}
