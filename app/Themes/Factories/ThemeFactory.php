<?php

namespace App\Themes\Factories;

use App\Themes\Contracts\ThemeInterface;
use App\Themes\Strategies\DefaultTheme;
use App\Themes\Strategies\NuevoTheme;
use App\Themes\Strategies\PharmaTheme;
use App\Themes\Strategies\Prueba2Theme;
use App\Themes\Strategies\PruebaTheme;

class ThemeFactory
{
    public static function make(string $themeName): ThemeInterface
    {
        return match ($themeName) {
            'default' => new DefaultTheme(),
            'nuevo' => new NuevoTheme(),
            'pharma' => new PharmaTheme(),
            'prueba2' => new Prueba2Theme(),
            'prueba' => new PruebaTheme(),
            default => throw new \InvalidArgumentException("Theme {$themeName} not found"),
        };
    }
}