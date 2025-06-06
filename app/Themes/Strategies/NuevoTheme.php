<?php

namespace App\Themes\Strategies;

use App\Themes\Contracts\ThemeInterface;

class NuevoTheme implements ThemeInterface
{
    public function getViewPath(string $viewName): string
    {
        $viewPath = "themes.nuevo.{$viewName}";

        if (!view()->exists($viewPath)) {
            $viewPath = "themes.default.{$viewName}";
        }

        return $viewPath;
    }

    public function getLayoutPath(): string
    {
        $layoutPath = "layouts.themes.nuevo";

        if (!view()->exists('components.' . $layoutPath)) {
            $layoutPath = "layouts.themes.default";
        }
        
        return $layoutPath;
    }
}