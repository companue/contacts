<?php

namespace Companue\Contacts\Facades;

use Illuminate\Support\Facades\Facade;

class Contacts extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'contacts';
    }
}
