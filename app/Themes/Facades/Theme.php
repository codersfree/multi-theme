<?php

namespace App\Themes\Facades;

use Illuminate\Support\Facades\Facade;

class Theme extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'theme';
    }
}