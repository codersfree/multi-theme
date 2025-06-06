<?php

namespace App\Themes\Strategies;

use App\Themes\Contracts\ThemeInterface;

class PruebaTheme implements ThemeInterface
{
    public function getViewPath(string $viewName): string
    {
        $viewPath = "themes.prueba.{$viewName}";

        if (!view()->exists($viewPath)) {
            $viewPath = "themes.default.{$viewName}";
        }

        return $viewPath;
    }

    public function getLayoutPath(): string
    {
        $layoutPath = "layouts.themes.prueba";

        if (!view()->exists('components.' . $layoutPath)) {
            $layoutPath = "layouts.themes.default";
        }
        
        return $layoutPath;
    }
}