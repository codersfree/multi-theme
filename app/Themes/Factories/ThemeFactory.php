<?php

namespace App\Themes\Factories;

use App\Themes\Contracts\ThemeInterface;
use App\Themes\Strategies\DefaultTheme;
use App\Themes\Strategies\PharmaTheme;

class ThemeFactory
{
    public static function make(string $themeName): ThemeInterface
    {
        return match ($themeName) {
            'default' => new DefaultTheme(),
            'pharma' => new PharmaTheme(), // Assuming 'pharma' uses the same strategy as 'default'
            default => throw new \InvalidArgumentException("Theme {$themeName} not found"),
        };
    }
}