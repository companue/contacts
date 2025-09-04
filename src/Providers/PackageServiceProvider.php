<?php

namespace Companue\Contacts\Providers;

use Companue\Contacts\Contacts;
use Illuminate\Support\ServiceProvider;

class PackageServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Ensure parent boot is called for compatibility
        if (method_exists(parent::class, 'boot')) {
            parent::boot();
        }

        $this->loadViewsFrom(
            $this->basePath('resources/views/'),
            'contacts'
        );

        $this->loadMigrationsFrom(
            $this->basePath('database/migrations')
        );

        $this->loadTranslationsFrom(
            $this->basePath('lang'),
            'contacts'
        );

        $this->loadJsonTranslationsFrom(
            $this->basePath('lang/json')
        );

        $this->publishes([
            $this->basePath('lang') => base_path('lang/vendor/contacts')
        ], 'contacts-translations');

        $this->publishes([
            $this->basePath('database/migrations') => database_path('migrations')
        ], 'contacts-migrations');

        $this->publishes([
            $this->basePath('resources/views/') => resource_path('views/vendor/contacts')
        ], 'contacts-views');

        $this->publishes(
            [
                $this->basePath('config/contacts.php') => base_path('config/contacts.php')
            ],
            'contacts-configuration'
        );

        $this->publishes([
            $this->basePath('/resources/static') => public_path('vendor/contacts')
        ], 'contacts-assets');

        if ($this->app->runningInConsole()) {
            $this->commands([
                // ConsoleCommand::class,
            ]);
        }
    }

    public function register()
    {
        $this->app->bind('contacts', function () {
            return new Contacts;
        });

        $this->mergeConfigFrom($this->basePath('config/contacts.php'), 'contacts');
    }

    protected function basePath($path = '')
    {
        return __DIR__ . '/../../' . $path;
    }
}
