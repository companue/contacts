<?php

namespace Companue\Contacts\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'Companue\Contacts\Http\Controllers';

    public function map()
    {
        Route::namespace($this->namespace)
            ->middleware('web')
            ->group(__DIR__ . '/../../routes/web.php');

        Route::namespace($this->namespace)
            ->middleware('api')
            ->prefix('api')
            ->group(__DIR__ . '/../../routes/api.php');
    }
}
