<?php

namespace Companue\Contacts\Providers;

use Companue\Contacts\Contacts;
use Illuminate\Support\ServiceProvider;

class PackageServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Load package routes
        if (file_exists($routes = $this->basePath('routes/api.php'))) {
            $this->loadRoutesFrom($routes);
        }

        $this->loadViewsFrom($this->basePath('resources/views/'), 'contacts');
        $this->loadMigrationsFrom($this->basePath('database/migrations'));
        $this->loadTranslationsFrom($this->basePath('lang'), 'contacts');
        $this->loadJsonTranslationsFrom($this->basePath('lang/json'));

        // Publish migrations
        $this->publishes([
            $this->basePath('database/migrations') => database_path('migrations'),
        ], 'contacts-migrations');

        // Publish translations
        $this->publishes([
            $this->basePath('lang') => base_path('lang/vendor/contacts'),
        ], 'contacts-translations');

        // Publish views
        $this->publishes([
            $this->basePath('resources/views/') => resource_path('views/vendor/contacts'),
        ], 'contacts-views');

        // Publish config
        $this->publishes([
            $this->basePath('config/contacts.php') => base_path('config/contacts.php'),
        ], 'contacts-configuration');

        // Publish assets
        $this->publishes([
            $this->basePath('resources/static') => public_path('vendor/contacts'),
        ], 'contacts-assets');

        // Publish system-package folder
        $this->publishes([
            $this->basePath('storage/system-package') => storage_path('system/contacts'),
        ], 'contacts-system-package');

        if ($this->app->runningInConsole()) {
            $this->commands([
                // ConsoleCommand::class,
            ]);
        }

        // Publish system-package files to storage/system/packages/contacts
        $systemPackagePath = $this->basePath('storage/system-package');
        $publishFiles = [];
        foreach (glob($systemPackagePath . '/*') as $file) {
            $publishFiles[$file] = storage_path('system/packages/contacts/' . basename($file));
        }
        $this->publishes($publishFiles, 'contacts-system-package');
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
