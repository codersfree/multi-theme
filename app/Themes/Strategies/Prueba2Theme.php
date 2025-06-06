<?php

namespace App\Themes\Strategies;

use App\Themes\Contracts\ThemeInterface;

class Prueba2Theme implements ThemeInterface
{
    public function getViewPath(string $viewName): string
    {
        $viewPath = "themes.prueba2.{$viewName}";

        if (!view()->exists($viewPath)) {
            $viewPath = "themes.default.{$viewName}";
        }

        return $viewPath;
    }

    public function getLayoutPath(): string
    {
        $layoutPath = "layouts.themes.prueba2";

        if (!view()->exists('components.' . $layoutPath)) {
            $layoutPath = "layouts.themes.default";
        }
        
        return $layoutPath;
    }
}